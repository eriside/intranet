<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\zeugnisse;

class SignCertificates implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ids, $name;

    public function __construct(array $ids, string $name)
    {
        $this->ids = $ids;
        $this->name = $name;
    }

    public function handle()
    {
        foreach ($this->ids as $id) {
            $zeugnis = zeugnisse::find($id);
            if (!$zeugnis) continue;

            $pdf = Pdf::loadView('intranet.vorlagen.landesschuleurkunde', [
                'name' => $zeugnis->name,
                'genurtsdatum' => $zeugnis->geburtsdatum,
                'datum' => $zeugnis->datum,
                'ausbildungname' => $zeugnis->bezeichnung,
                'ausbilder' => $zeugnis->ausbilder,
                'datum2' => $zeugnis->datum2,
                'schulleitung' => $this->name,
                'id' => $zeugnis->ausbildung,
            ]);

            $pdf->addInfo([
                'Producer' => json_encode([
                    'name' => $zeugnis->name,
                    'geburtsdatum' => $zeugnis->geburtsdatum,
                    'datum' => $zeugnis->datum,
                    'ausbildungname' => $zeugnis->bezeichnung,
                    'ausbilder' => $zeugnis->ausbilder,
                    'datum2' => $zeugnis->datum2,
                    'schulleitung' => $this->name,
                    'id' => $zeugnis->ausbildung,
                ])
            ]);

            $botToken = env('DISCORD_BOT_TOKEN');

            $dmResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $botToken,
                'Content-Type' => 'application/json',
            ])->post('https://discord.com/api/v10/users/@me/channels', [
                'recipient_id' => $zeugnis->user_id,
            ]);

            if (!$dmResponse->successful()) {
                \Log::error('DM-Kanal konnte nicht erstellt werden für User ' . $zeugnis->user_id);
                continue;
            }

            $dmChannelId = $dmResponse->json()['id'];
            $pdfPath = "urkunden/urkunde_{$zeugnis->id}.pdf";
            Storage::put($pdfPath, $pdf->output());

            $response = Http::withHeaders([
                'Authorization' => 'Bot ' . $botToken,
            ])->attach(
                'file',
                Storage::get($pdfPath),
                "Urkunde-{$zeugnis->name}-{$zeugnis->bezeichnung}.pdf"
            )->post("https://discord.com/api/v10/channels/{$dmChannelId}/messages", [
                'content' => 'Hier ist deine Urkunde!',
            ]);

            if ($response->successful()) {
                Storage::delete($pdfPath);
                $zeugnis->delete();
            }

            sleep(1); // optional, falls Discord-Rate-Limit
        }
    }
}

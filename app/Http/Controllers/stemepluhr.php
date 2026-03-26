<?php

namespace App\Http\Controllers;

use App\Models\lager;
use App\Models\stempeluhr;
use App\Models\Mitarbeiter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class stemepluhr extends Controller
{
    public function handletimer(Request $request, $id, $id2)
    {


        $userID=$id;
        $status=$id2;

        if ($status=='on') {

            if (stempeluhr::where('user_id',$userID)->whereNull('end_time')->exists()) {
                return response()->json(['message' => 'Ungültige Anfrage'], 400);
            } else{
                $time= stempeluhr::create([
                    'user_id' => $userID,
                    'start_time' => Carbon::now(),
                ]);

                return response()->json(['message' => 'Timer gestartet', 'time' => $time], 200);
            }

        }

        if ($status=='off') {
            $time = stempeluhr::where('user_id',$userID)->whereNull('end_time')->latest()->first();

            if (!$time) {
                return response()->json(['message' => 'Kein aktiver Timer gefunden'], 404);
            }

            $time->update([
                'end_time' => Carbon::now(),
            ]);
            return response()->json(['message' => 'Timer gestoppt', 'timer' => $time], 200);
        }

        return response()->json(['message' => 'Ungültige Anfrage'], 400);
    }

    public function wegmitalle(Request $request)
    {
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $time = stempeluhr::whereNull('end_time');

        foreach ($time->get() as $time) {
            $time->update([
                'end_time' => Carbon::now(),
            ]);
        }

        return response()->json(['message' => 'geil'], 200);
    }

    public function log()
    {
        $namen = Mitarbeiter::all()->keyBy('id'); // für schnelleren Zugriff per ID
        $logs = stempeluhr::orderBy('start_time', 'desc')->paginate(50); // Pagination mit 50 Einträgen

        return view('intranet.administration.stempeluhr', compact('namen', 'logs'));
    }

    public function eingestempelt()
    {
        $namen = \App\Models\Mitarbeiter::all();
        $logs = stempeluhr::whereNull('end_time')->get();

        return view('intranet.verwaltung.eingestempelt', compact('namen', 'logs'));
    }

    public function logg(Request $request, $id, $id2, $id3)
    {
        $userID=$id;
        $value=$id2;
        $anzahl=$id3;

        $log = new lager();
        $log->user_id = $userID;
        $log->value = $value;
        $log->anzahl = $anzahl;
        $log->save();

        if ($anzahl >=25){
            $fields = [];
            $fields[] = [
                'name' => 'Name:',
                'value' => Mitarbeiter::find($userID)->name,
                'inline' => false
            ];
            $fields[] = [
                'name' => 'Item:',
                'value' => $value,
                'inline' => false
            ];
            $fields[] = [
                'name' => 'Anzahl:',
                'value' => $anzahl,
                'inline' => false
            ];
            Http::post(env('DISCORD_WEBHOOK_STEMPELUHR'), [
                'content' => "<@&1113881546181578913>",
                'embeds' => [
                    [
                        'title' => 'Zu Hohe herausnahme',
                        'color' => 7506394,
                        'fields' => $fields
                    ]
                ]
            ]);
        }

        return response()->json(['message' => 'Erfolgreich geloggt'], 200);
    }
}

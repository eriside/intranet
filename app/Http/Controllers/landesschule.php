<?php

namespace App\Http\Controllers;

use App\Models\ausbilder;
use App\Models\ausbildungen;
use App\Models\ausbildungsangebot;
use App\Models\dokumente;
use App\Models\zeugnisse;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use http\Env\Response;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Docs;

class landesschule extends Controller
{
    public function ausbildungen(){
        $ausbildungen = ausbildungen::all();
        return view('intranet.administration.ausbildungen', compact('ausbildungen'));
    }

    public function newausbildungen(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'discord_id' => 'required|integer',
            'vorher' => 'nullable|integer',
        ]);

        $ausbildungen = new ausbildungen();
        $ausbildungen->name = $validated['name'];
        $ausbildungen->discordID = $validated['discord_id'];
        $ausbildungen->vorher  = $validated['vorher'];
        $ausbildungen->save();

        return back()->with('msg', 'Ausbildung erfolgreich angelegt');
    }

    public function editausbildungen(Request $request,$id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'discord_id' => 'required|integer',
            'vorher' => 'nullable|integer',
        ]);
        $ausbildung = ausbildungen::find($id);
        $ausbildung->name = $validated['name'];
        $ausbildung->discordID = $validated['discord_id'];
        $ausbildung->vorher  = $validated['vorher'];
        $ausbildung->save();

        return back()->with('msg', 'Ausbildung erfolgreich aktualisiert');
    }
    public function deleteausbildungen(Request $request,$id){
        $ausbildung = ausbildungen::find($id);
        $ausbildung->delete();
        return back()->with('msg', 'Ausbidung erfolgreich gelöscht');
    }

    public function ausbilder()
    {
        $ausbilder = ausbilder::all();
        $ausbildungen = ausbildungen::all();
        return view('intranet.landesschule.ausbilder', compact('ausbilder', 'ausbildungen'));

    }

    public function newausbilder(Request $request){
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'options' => 'nullable|array',
        ]);

        $ausbilder = new ausbilder();
        $ausbilder->id = $validated['id'];
        $ausbilder->name = $validated['name'];
        $ausbilder->ausbildungen = json_encode($request->input('options', []));
        $ausbilder->save();
        return back()->with('msg', 'Ausbilder erfolgreich angelegt');

    }
    public function editausbilder(Request $request,$id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'options' => 'nullable|array',
        ]);

        $ausbilder = ausbilder::find($id);
        $ausbilder->name = $validated['name'];
        $ausbilder->ausbildungen = json_encode($request->input('options', []));
        $ausbilder->save();
        return back()->with('msg', 'Ausbilder erfolgreich geändert');
    }

    public function deleteausbilder(Request $request,$id){
        $ausbilder = ausbilder::find($id);
        $ausbilder->delete();
        return back()->with('msg', 'ausbilder erfolgreich gelöscht');
    }

    public function createausbildungsangebot(Request $request){

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ausbilder = ausbilder::find($request->input('user_id'));
        $ausbildung = ausbildungen::find($request->input('ausbildung_id'));
        $angebot = new ausbildungsangebot();
        $angebot->ausbilder = $ausbilder->id;
        $angebot->ausbildung = $ausbildung->id;
        $angebot->teilnehmer = json_encode([]);
        $angebot->aktiv = true;
        $angebot->save();

        return response()->json(['success' => true, 'message' => $angebot->id, 'name' => $ausbildung->name]);

    }

    public function adduserausbildungsangebot(Request $request){
        $apiKey = $request->header('X-API-Key');
        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $angebot = ausbildungsangebot::find($request->input('ausbildung_id'));
        $teilnehmer = json_decode($angebot->teilnehmer, true) ?? [];
        $user = ['id'=>(int) $request->input('user_id') ,'name'=>$request->input('name'), 'geburtsdatum' => $request->input('geburtsdatum'), 'bestanden' => null];
        if (!in_array($user, $teilnehmer)) {
            $teilnehmer[] = $user;
            $angebot->teilnehmer = json_encode($teilnehmer);
            $angebot->save();
        }
        return response()->json(['success' => true]);
    }

    public function closeausbildungsangebot(Request $request){
        $apiKey = $request->header('X-API-Key');
        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $angebot = ausbildungsangebot::find($request->input('ausbildung_id'));
        if ($angebot->ausbilder == $request->input('user_id')) {
            $angebot->aktiv = false;
            $angebot->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);

    }

    public function getausbildungen(Request $request){
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $ausbilder = ausbilder::find($request->input('user_id'));

        $allowedIds = json_decode($ausbilder->ausbildungen, true) ?? [];

        $ausbildungen = ausbildungen::whereIn('id', $allowedIds)->get();
        return response()->json(['success' => true, 'raenge' => $ausbildungen]);
    }

    public function allausbildungsangebote(Request $request){
        $user = Auth::user();
        $ausbildungsangebote = ausbildungsangebot::where('ausbilder', $user->id)->where('proccessed', false)->get();
        $ausbildungen = ausbildungen::all();
        return view('intranet.landesschule.ausbildungsangebote', compact('ausbildungsangebote', 'ausbildungen'));
    }

    public function viewausbildungsangebot(Request $request, $id){
        $ausbildung = ausbildungsangebot::find($id);
        $asubildungen = ausbildungen::all();
        return view('intranet.landesschule.viewausbildungsangebote', compact('ausbildung', 'asubildungen'));
    }

    public function pass(Request $request, $id, $id2) {
        $user_id = $id2;
        $ausbildung = ausbildungsangebot::find($id);

        $teilnehmerListe = json_decode($ausbildung->teilnehmer);

        foreach ($teilnehmerListe as $teilnehmer) {
            if (isset($teilnehmer->id) && $teilnehmer->id == $user_id) {
                $teilnehmer->bestanden = true;

                $zeugniss = new zeugnisse();
                $zeugniss->user_id = $user_id;
                $zeugniss->ausbildung = $ausbildung->id;
                $zeugniss->bezeichnung = ausbildungen::find($ausbildung->ausbildung)->name;
                $zeugniss->name = $teilnehmer->name;
                $zeugniss->geburtsdatum = $teilnehmer->geburtsdatum;
                $zeugniss->datum = $ausbildung->created_at;
                $zeugniss->ausbilder = ausbilder::find($ausbildung->ausbilder)->name;

                $zeugniss->save();
            }
        }

        $ausbildung->teilnehmer = json_encode($teilnehmerListe);
        $ausbildung->save();
        $botToken = env('DISCORD_BOT_TOKEN');

        $dmResponse = Http::withHeaders([
            'Authorization' => 'Bot ' . $botToken,
            'Content-Type' => 'application/json',
        ])->post('https://discord.com/api/v10/users/@me/channels', [
            'recipient_id' => $user_id,
        ]);

        $dmChannelId = $dmResponse->json()['id'];
        $anal = ausbildungen::find($ausbildung->ausbildung)->name;
        $embedPayload = [
            'embeds' => [[
                'title' => 'Ausbildungsergebnis!',
                'description' => "Dein Ergebnis für die Ausbildung **{$anal}** ist da!",
                'color' => hexdec("1abc9c"),
                'fields' => [
                    [
                        'name' => 'Status',
                        'value' => "Bestanden 🎉",
                        'inline' => false,
                    ]
                ],
                'footer' => [
                    'text' => 'Made by @eri_side',
                ],
            ]]
        ];

        Http::withHeaders([
            'Authorization' => 'Bot ' . $botToken,
            'Content-Type' => 'application/json',
        ])->post("https://discord.com/api/v10/channels/{$dmChannelId}/messages", $embedPayload);

        foreach (json_decode($ausbildung->teilnehmer) as $teilnehmer){
            if ($teilnehmer->bestanden === null) {
                return back()->with('msg', 'Teilnehmer erfolgreich bestanden!');
            }
        }
        $ausbildung->proccessed = true;
        $ausbildung->save();





        return back()->with('msg', 'Alle Teilnehmer bewertet!');
    }

    public function fail(Request $request, $id, $id2) {
        $user_id = $id2;
        $ausbildung = ausbildungsangebot::find($id);

        $teilnehmerListe = json_decode($ausbildung->teilnehmer);

        foreach ($teilnehmerListe as $teilnehmer) {
            if (isset($teilnehmer->id) && $teilnehmer->id == $user_id) {
                $teilnehmer->bestanden = false;
            }
        }

        $ausbildung->teilnehmer = json_encode($teilnehmerListe);
        $ausbildung->save();
        $botToken = env('DISCORD_BOT_TOKEN');

        $dmResponse = Http::withHeaders([
            'Authorization' => 'Bot ' . $botToken,
            'Content-Type' => 'application/json',
        ])->post('https://discord.com/api/v10/users/@me/channels', [
            'recipient_id' => $user_id,
        ]);

        $dmChannelId = $dmResponse->json()['id'];
        $anal = ausbildungen::find($ausbildung->ausbildung)->name;
        $embedPayload = [
            'embeds' => [[
                'title' => 'Ausbildungsergebnis!',
                'description' => "Dein Ergebnis für die Ausbildung **{$anal}** ist da!",
                'color' => hexdec("ff0000"),
                'fields' => [
                    [
                        'name' => 'Status',
                        'value' => "Durchgefallen ❌",
                        'inline' => false,
                    ]
                ],
                'footer' => [
                    'text' => 'Made by @eri_side',
                ],
            ]]
        ];

        Http::withHeaders([
            'Authorization' => 'Bot ' . $botToken,
            'Content-Type' => 'application/json',
        ])->post("https://discord.com/api/v10/channels/{$dmChannelId}/messages", $embedPayload);


        foreach (json_decode($ausbildung->teilnehmer) as $teilnehmer){
            if ($teilnehmer->bestanden === null) {
                return back()->with('msg', 'Teilnehmer erfolgreich durchgefallen!');
            }
        }
        $ausbildung->proccessed = true;
        $ausbildung->save();
        return back()->with('msg', 'Alle Teilnehmer bewertet!');

    }

    public function zeugnisse(){
        $zeugnisse = zeugnisse::all()->sortBy('ausbildung');
        $ausbildungen = ausbildungen::all();
        $mitarbeiter = \App\Models\Mitarbeiter::all();
        $ausbilder = ausbilder::all();
        return view('intranet.landesschule.zeugnisse', compact('zeugnisse', 'ausbildungen', 'mitarbeiter', 'ausbilder'));
    }

    public function sign(Request $request)
    {
        $templateId = '1BHi1gxzU6HLLJQ0IUPW004dDZ__YT9X3mHIXVd52LGM'; // Deine Vorlage
            
        // WICHTIG: Hier die ID deines freigegebenen Ordners eintragen!
        // Beispiel: '1AbCdEfGhIjKlMnOpQrStUvWxYz'
        $targetFolderId = '14-ZuZP8xCiOa5m0IlKSXGgLqngxP-tJQ'; 
        // ---------------------
        // Google Client Setup
        $client = new Client();
        // Statt setAuthConfig:
        $client->setClientId(env('GOOGLE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));
        $client->addScope(Drive::DRIVE);
        $client->addScope(Docs::DOCUMENTS);
        $driveService = new Drive($client);
        $docsService = new Docs($client);


        $validated = $request->validate([
            'name' => 'required|string',
            'zeugnis_ids' => 'required|array',
            'zeugnis_ids.*' => 'integer'
        ]);

        $ids = $validated['zeugnis_ids'];
        foreach ($ids as $id) {
            $zeugnis = zeugnisse::find($id);

            

            try {
                $fileMetadata = new Drive\DriveFile([
                    'name' => 'Arbeitsvertrag_' . preg_replace('/[^A-Za-z0-9\-]/', '', $request->query('name')),
                    'parents' => [$targetFolderId] // Speichert die Datei in DEINEM Ordner
                ]);
                
                $newFile = $driveService->files->copy($templateId, $fileMetadata);
                $newFileId = $newFile->id;
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Fehler beim Erstellen der Datei.',
                    'details' => $e->getMessage(),
                    'hint' => 'Hast du den Ziel-Ordner mit der Service-Account-Email geteilt?'
                ], 500);
            }

            // 2. Platzhalter ersetzen
            
            $replacements = [
                '{{NameUrkunde}}' => 'Zertifikat',
                '{{Nameaufurkunde}}'=> $zeugnis->name,
                '{bday}}' => $zeugnis->geburtsdatum,
                '{{ArtAusbildung}}' => 'Ausbildung',
                '{{NameTitel}}' => $zeugnis->bezeichnung,
                '{{heute}}' => Carbon::today()->format('d.m.Y'),
                '{{unterschriftschul}}' => $validated['name'],
                '{{unterschriftAusbilder1}}' => $zeugnis->ausbilder,
            ];

            $requests = [];
            foreach ($replacements as $placeholder => $replacement) {
                // Sicherstellen, dass replacement ein String ist
                $text = is_null($replacement) ? '' : (string) $replacement;
                
                $requests[] = new Docs\Request([
                    'replaceAllText' => [
                        'containsText' => ['text' => $placeholder, 'matchCase' => true],
                        'replaceText' => $text,
                    ]
                ]);
            }

            if (count($requests) > 0) {
                try {
                    $docsService->documents->batchUpdate($newFileId, new Docs\BatchUpdateDocumentRequest(['requests' => $requests]));
                } catch (\Exception $e) {
                    // Falls Suchen & Ersetzen fehlschlägt, Datei trotzdem aufräumen
                    $driveService->files->delete($newFileId);
                    return response()->json(['error' => 'Fehler beim Ersetzen der Platzhalter: ' . $e->getMessage()], 500);
                }
            }

            // 3. PDF Exportieren
            try {
                $response = $driveService->files->export($newFileId, 'application/pdf', array('alt' => 'media'));
                $content = $response->getBody()->getContents();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Fehler beim PDF Export: ' . $e->getMessage()], 500);
            }

            // 4. Lokal Speichern
            $filename = "urkunde_{$zeugnis->id}.pdf";
            //$path = public_path('dokumente/' . $filename);
            //file_put_contents($path, $content);
            Storage::put("dokumente/urkunde_{$zeugnis->id}.pdf", $content);


            try {
                $driveService->files->delete($newFileId);
            } catch (\Exception $e) {
                // Nicht kritisch
            }


            $botToken = env('DISCORD_BOT_TOKEN');

            $dmResponse = Http::withHeaders([
                'Authorization' => 'Bot ' . $botToken,
                'Content-Type' => 'application/json',
            ])->post('https://discord.com/api/v10/users/@me/channels', [
                'recipient_id' => $zeugnis->user_id,
            ]);

            if (!$dmResponse->successful()) {
                error_log('DM-Kanal konnte nicht erstellt werden für User');

                continue;
            }

            $dmChannelId = $dmResponse->json()['id'];


            $content = Storage::get("dokumente/urkunde_{$zeugnis->id}.pdf");

            $response = Http::withHeaders([
                'Authorization' => 'Bot ' . $botToken,
            ])->attach(
                'file',
                $content,
                "Urkunde-{$zeugnis->name}-{$zeugnis->bezeichnung}.pdf"
            )->post("https://discord.com/api/v10/channels/{$dmChannelId}/messages", [
                'content' => 'Hier ist deine Urkunde!',
            ]);

            if ($response->successful()) {
                Storage::delete("urkunden/urkunde_{$zeugnis->id}.pdf");
                $zeugnis->delete();
            }

            sleep(1);
        }
        return back()->with('msg', 'Alle Teilnehmer unterschrieben!');
    }

    public function createZeugnis(Request $request){
        $validated = $request->validate([
            'name1' => 'required|string',
            'discordid' => 'required|integer',
            'geburtsdatum' => 'required|string',
            'datum' => 'required|date',
            'ausbildung' => 'required|integer',
            'ausbilder' => 'required|integer',
        ]);

        $ausbildung = ausbildungen::find($validated['ausbildung']);
        $angebot = new ausbildungsangebot();
        $angebot->ausbildung = $validated['ausbildung'];
        $user= ['id'=>$validated['discordid'] ,'name'=>$validated['name1'], 'geburtsdatum' => $validated['geburtsdatum'], 'bestanden' => true];
        $angebot->teilnehmer = json_encode([$user]);
        $angebot->aktiv = false;
        $angebot->ausbilder = $validated['ausbilder'];
        $angebot->proccessed = true;
        $angebot->save();

        $zeugnis = new zeugnisse();
        $zeugnis-> ausbildung = $angebot->id;
        $zeugnis->bezeichnung = $ausbildung->name;
        $zeugnis->user_id = $validated['discordid'];
        $zeugnis->name = $validated['name1'];
        $zeugnis->geburtsdatum = $validated['geburtsdatum'];
        $zeugnis->ausbilder = ausbilder::find($validated['ausbilder'])->name;
        $zeugnis->datum = $validated['datum'];
        $zeugnis->datum2 = Carbon::now();
        $zeugnis->save();

        return back()->with('msg', 'Zeugnisse wurde erstellt!');

    }

    public function upload(Request $request)
    {
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $angebot = ausbildungsangebot::find($request->query("id"));
        $ausbildung = ausbildungen::find($angebot->ausbildung);
        if ($angebot) {
            foreach (json_decode($angebot->teilnehmer) as $teilnehmer) {
                if ($teilnehmer->id == $request->query('user_id') and $teilnehmer->bestanden) {

                    $pdf = Pdf::loadView('intranet.vorlagen.landesschuleurkunde', [
                        'name' => $request->query("name"),
                        'genurtsdatum' => $request->query("geburtsdatum"),
                        'datum' => $request->query("datum"),
                        'ausbildungname' => $request->query("ausbildungname"),
                        'ausbilder' => $request->query("ausbilder"),
                        'datum2' => $request->query("datum2"),
                        'schulleitung' => $request->query("schulleitung"),
                        'id' => $request->query("id"),
                    ]);
                    $pdf->addInfo([
                        'Producer' => json_encode([
                            'name' => $request->query("name"),
                            'genurtsdatum' => $request->query("geburtsdatum"),
                            'datum' => $request->query("datum"),
                            'ausbildungname' => $request->query("ausbildungname"),
                            'ausbilder' => $request->query("ausbilder"),
                            'datum2' => $request->query("datum2"),
                            'schulleitung' => $request->query("schulleitung"),
                            'id' => $request->query("id"),
                        ])
                    ]);
                    $name = time().'.pdf';
                    $path = public_path('dokumente/'.$name);
                    $pdf->save($path);


                    $doc = new dokumente();
                    $doc->name = "Urkunde-{$request->query("name")}-{$request->query("ausbildungname")}.pdf";
                    $doc->user_id = (int) $request->query('user_id');
                    $doc->type = 6;
                    $doc->path = $name;
                    $doc->save();

                    return response()->json(['success' => 'OK', 'ausbildung' => $ausbildung], 200);
                }
            }
        }

        return response()->json(['error' => 'Es ist ein Fehler aufgetreten'], 400);

    }



}

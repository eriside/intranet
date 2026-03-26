<?php

namespace App\Http\Controllers;

use App\Models\dokumente;
use App\Models\raenge;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Docs;


class filecreate extends Controller
{
    public function generiereVertrag(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        
        
        // --- KONFIGURATION ---
        if ($request->query('arbeitsverhaltnis') == 'Vollzeit'){
            $templateId = '1xal3EREyIFYCZDxEPzuW2FQFvUfUkuD2hXc0GSPW6Ag'; // Deine Vorlage
            
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

            // 1. Kopie im Zielordner erstellen
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
                '{{AVAN}}'           => $request->query('name'),
                '{{DatumAV}}'        => $request->query('einstellung'),
                '{{Rang}}'           => $request->query('rang'),
                '{{UnterschriftAN}}' => $request->query('name'),
                '{{UnterschriftVW}}' => $request->query('verwalter'),
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
            $filename = time() . '.pdf';
            $path = public_path('dokumente/' . $filename);
            $doc = new dokumente();
            $doc->name = 'Arbeitsvertrag';
            $doc->user_id = (int) $request->query('user_id');
            $doc->type = 2;
            $doc->path = $filename;
            $doc->save();

            file_put_contents($path, $content);

            // 5. Aufräumen: Temporäre Datei auf Drive löschen
            // Da die Datei in DEINEM Ordner liegt, würde sie dort sonst liegen bleiben.
            // Wir löschen sie, damit dein Drive sauber bleibt.
            try {
                $driveService->files->delete($newFileId);
            } catch (\Exception $e) {
                // Nicht kritisch
            }

            return response()->json(['success' => true, 'message' => url('/file/' . $filename)]);
        } else {
            $templateId = '1aTNRoRDxa_vkyw4nKr8M387-fwilRZXsNiMEjeWpknI'; // Deine Vorlage
            
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

            // 1. Kopie im Zielordner erstellen
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
                '{{MitarbeiterEA}}'           => $request->query('name'),
                '{{EADatum}}'        => $request->query('einstellung'),
                '{UnterschriftANEA}}' => $request->query('name'),
                '{{VerwalterEA}}' => $request->query('verwalter'),
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
            $filename = time() . '.pdf';
            $path = public_path('dokumente/' . $filename);
            $doc = new dokumente();
            $doc->name = 'Arbeitsvertrag';
            $doc->user_id = (int) $request->query('user_id');
            $doc->type = 2;
            $doc->path = $filename;
            $doc->save();

            file_put_contents($path, $content);

            // 5. Aufräumen: Temporäre Datei auf Drive löschen
            // Da die Datei in DEINEM Ordner liegt, würde sie dort sonst liegen bleiben.
            // Wir löschen sie, damit dein Drive sauber bleibt.
            try {
                $driveService->files->delete($newFileId);
            } catch (\Exception $e) {
                // Nicht kritisch
            }

            return response()->json(['success' => true, 'message' => url('/file/' . $filename)]);
        }
    }

    public function einstellung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $rang = raenge::find((int) $request->query('rang'));

        $gehalt = $rang->gehalt;

        $pdf = Pdf::loadView('intranet.vorlagen.arbeitsvertrag', [
            'mitarbeiter' => $request->query('name'),
            'arbeitsverhaltnis' => $request->query('arbeitsverhaltnis'),
            'einstellung' => $request->query('einstellung'),
            'rang' => $rang->name,
            'gehalt' => $gehalt,
            'verwalter' => $request->query('verwalter'),
            'datum2' => Carbon::today()->format('d.m.Y'),
            'position' => $request->query('position'),
        ]);

        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);

        $doc = new dokumente();
        $doc->name = 'Arbeitsvertrag';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 4;
        $doc->path = $name;
        $doc->save();
        $dienstnummer = -1;
        for ($i= 61; $i <= 999; $i++) {
            $frei = \App\Models\Mitarbeiter::where('dienstnummer', $i)->exists();
            if (!$frei){
                $dienstnummer = $i;
                $mitarbeiter = new \App\Models\Mitarbeiter();
                $mitarbeiter->dienstnummer = $i;
                $mitarbeiter->id = (int) $request->query('user_id');
                $mitarbeiter->name = $request->query('name');
                $mitarbeiter->dienstgrad = (int) $request->query('rang');
                $mitarbeiter->naechste_befoerderung = Carbon::now()->addWeeks($rang->time_till);
                $mitarbeiter->arbeitsverhaltnis = $request->query('arbeitsverhaltnis');
                $mitarbeiter->geburtsdatum = $request->query('geburtsdatum');
                $mitarbeiter->geschlecht = $request->query('geschlecht');
                $mitarbeiter->telefonnummer = $request->query('telefonnummer');
                $mitarbeiter->iban = 1;
                $mitarbeiter->zulassung_nebenjob = false;
                $mitarbeiter->nebenjob = "n.a.";
                $mitarbeiter->nebenjob_von = "n.a.";
                $mitarbeiter->baeamtenstatus = "Keine Verbeamtung";
                $mitarbeiter->aktiv = true;
                $mitarbeiter->save();

                break;
            }
        }



        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'dienstnummer' => $dienstnummer, 'rang' => $rang,]);
    }

    public function freie_dienstnummer(Request $request)
    {
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $dienstnummer = -1;
        for ($i= 31; $i <= 999; $i++) {
            $frei = \App\Models\Mitarbeiter::where('dienstnummer', $i)->exists();
            if (!$frei){
                $dienstnummer = $i;

                break;
            }
        }



        return response()->json(['success' => true, 'dienstnummer' => $dienstnummer]);

    }
    public function generiereVertragohne(Request $request)
    {
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        
        
        // --- KONFIGURATION ---
        if ($request->query('arbeitsverhaltnis') == 'Vollzeit'){
            $templateId = '1xal3EREyIFYCZDxEPzuW2FQFvUfUkuD2hXc0GSPW6Ag'; // Deine Vorlage
            
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

            // 1. Kopie im Zielordner erstellen
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
                '{{AVAN}}'           => $request->query('name'),
                '{{DatumAV}}'        => $request->query('einstellung'),
                '{{Rang}}'           => $request->query('rang'),
                '{{UnterschriftAN}}' => '',
                '{{UnterschriftVW}}' => $request->query('verwalter'),
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
            $filename = time() . '.pdf';
            $path = public_path('dokumente/' . $filename);
            file_put_contents($path, $content);

            // 5. Aufräumen: Temporäre Datei auf Drive löschen
            // Da die Datei in DEINEM Ordner liegt, würde sie dort sonst liegen bleiben.
            // Wir löschen sie, damit dein Drive sauber bleibt.
            try {
                $driveService->files->delete($newFileId);
            } catch (\Exception $e) {
                // Nicht kritisch
            }

            return response()->json(['success' => true, 'message' => url('/file/' . $filename)]);
        } else{
            $templateId = '1aTNRoRDxa_vkyw4nKr8M387-fwilRZXsNiMEjeWpknI'; // Deine Vorlage
            
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

            // 1. Kopie im Zielordner erstellen
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
                '{{MitarbeiterEA}}'           => $request->query('name'),
                '{{EADatum}}'        => $request->query('einstellung'),
                '{UnterschriftANEA}}' => '',
                '{{VerwalterEA}}' => $request->query('verwalter'),
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
            $filename = time() . '.pdf';
            $path = public_path('dokumente/' . $filename);
            file_put_contents($path, $content);

            // 5. Aufräumen: Temporäre Datei auf Drive löschen
            // Da die Datei in DEINEM Ordner liegt, würde sie dort sonst liegen bleiben.
            // Wir löschen sie, damit dein Drive sauber bleibt.
            try {
                $driveService->files->delete($newFileId);
            } catch (\Exception $e) {
                // Nicht kritisch
            }

            return response()->json(['success' => true, 'message' => url('/file/' . $filename)]);
        }
    }


    public function befoerderung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));
        $oldrang = raenge::find($mitarbeiter->dienstgrad);
        $newrang = raenge::find((int) $request->query('rang'));

        $pdf = Pdf::loadView('intranet.vorlagen.befoerderung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'old' => $oldrang->name,
            'new' => $newrang->name,
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);


        $doc = new dokumente();
        $doc->name = 'Beförderung-'.$newrang->name;
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 5;
        $doc->path = $name;
        $doc->save();

        $mitarbeiter->dienstgrad = (int) $request->query('rang');
        $mitarbeiter->naechste_befoerderung = Carbon::now()->addWeeks($newrang->time_till);
        $mitarbeiter->save();


        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'old' => $oldrang]);
    }
    public function degradierung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));
        $oldrang = raenge::find($mitarbeiter->dienstgrad);
        $newrang = raenge::find((int) $request->query('rang'));

        $pdf = Pdf::loadView('intranet.vorlagen.degradierung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'old' => $oldrang->name,
            'new' => $newrang->name,
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
            'grund' => $request->query('grund'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);


        $doc = new dokumente();
        $doc->name = 'Degradierung-'.$newrang->name;
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 8;
        $doc->path = $name;
        $doc->save();

        $mitarbeiter->dienstgrad = (int) $request->query('rang');
        $mitarbeiter->naechste_befoerderung = Carbon::now()->addWeeks($newrang->time_till);
        $mitarbeiter->save();


        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'old' => $oldrang]);
    }

    public function getraenge(Request $request)
    {
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $raenge = raenge::all();
        return response()->json(['success' => true, 'raenge' => $raenge]);
    }

    public function getgenehmigung(Request $request)
    {
        $apiKey = $request->header('X-API-Key');

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $user = User::whereHas('roles', function ($query) {
            $query->where('role_id', 16);
        })->pluck('id')->toArray();
        $users = [];
        foreach ($user as $u) {
            $mitarbeiter = \App\Models\Mitarbeiter::where('id', $u)->pluck('name');
            $users[] = [$u, $mitarbeiter[0]];
        }
        return response()->json(['success' => true, 'user' => $users]);
    }


    public function kundigung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));


        $pdf = Pdf::loadView('intranet.vorlagen.kundigung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'grund'=>$request->query('grund'),
            'einstellung' => $request->query('einstellung'),
            'law' => $request->query('law'),
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);


        $doc = new dokumente();
        $doc->name = 'Kündigung';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 12;
        $doc->path = $name;
        $doc->save();



        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);
    }
    public function kundigungohne(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));


        $pdf = Pdf::loadView('intranet.vorlagen.kundigung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'grund'=>$request->query('grund'),
            'einstellung' => $request->query('einstellung'),
            'law' => $request->query('law'),
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);






        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'name' => $mitarbeiter->name]);
    }


    public function fristloskundigung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));


        $pdf = Pdf::loadView('intranet.vorlagen.fristloskundigung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'grund'=>$request->query('grund'),
            'einstellung' => $request->query('einstellung'),
            'law' => $request->query('law'),
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);


        $doc = new dokumente();
        $doc->name = 'Kündigung';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 12;
        $doc->path = $name;
        $doc->save();



        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);
    }
    public function fristloskundigungohne(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));


        $pdf = Pdf::loadView('intranet.vorlagen.fristloskundigung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'grund'=>$request->query('grund'),
            'einstellung' => $request->query('einstellung'),
            'law' => $request->query('law'),
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);






        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'name' => $mitarbeiter->name]);
    }


    public function abmahnungohne(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));


        $pdf = Pdf::loadView('intranet.vorlagen.abmahnungohne', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'grund'=>$request->query('grund'),
            'law' => $request->query('law'),
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);






        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'name' => $mitarbeiter->name]);
    }
    public function abmahnung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));


        $pdf = Pdf::loadView('intranet.vorlagen.abmahnung', [
            'geschlecht' => $mitarbeiter->geschlecht,
            'mitarbeiter' => $mitarbeiter->name,
            'grund'=>$request->query('grund'),
            'law' => $request->query('law'),
            'verwalter' => $request->query('verwalter'),
            'rang' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);

        $doc = new dokumente();
        $doc->name = 'Abmahnung';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 7;
        $doc->path = $name;
        $doc->save();




        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'name' => $mitarbeiter->name]);
    }


    public function zweitjobohne(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));

        $pdf = Pdf::loadView('intranet.vorlagen.2jobohne', [
            'mitarbeiter' => $mitarbeiter->name,
            'verwalter' => $request->query('verwalter'),
            'position' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');

        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);
        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'name' => $mitarbeiter->name]);
    }

    public function zweitjob(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));

        $pdf = Pdf::loadView('intranet.vorlagen.2job', [
            'mitarbeiter' => $mitarbeiter->name,
            'verwalter' => $request->query('verwalter'),
            'position' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');

        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);


        $doc = new dokumente();
        $doc->name = 'Zweit Job Genehmigung';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 16;
        $doc->path = $name;
        $doc->save();

        $mitarbeiter->zulassung_nebenjob = true;
        $mitarbeiter->nebenjob_von = $request->query('verwalter');
        $mitarbeiter->save();


        return response()->json(['success' => true, 'message' => url('/file/'.$name), 'name' => $mitarbeiter->name]);
    }

    public function aufhebungohne(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));
        $pdf = Pdf::loadView('intranet.vorlagen.aufhebungohne', [
            'mitarbeiter' => $mitarbeiter->name,
            'verwalter' => $request->query('verwalter'),
            'position' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);

        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);

    }

    public function aufhebung(Request $request)
    {

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $mitarbeiter = \App\Models\Mitarbeiter::find((int) $request->query('user_id'));
        $pdf = Pdf::loadView('intranet.vorlagen.aufhebung', [
            'mitarbeiter' => $mitarbeiter->name,
            'verwalter' => $request->query('verwalter'),
            'position' => $request->query('position'),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);


        $doc = new dokumente();
        $doc->name = 'Aufhebungsvertrag';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 16;
        $doc->path = $name;
        $doc->save();
        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);

    }

    public function navertrag(Request $request){
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $pdf = Pdf::loadView('intranet.vorlagen.notarztvertrag', [
            'mitarbeiter' => $request->query('name'),
            'verwalter' => $request->query('verwalter'),
            'datum2' => Carbon::today()->format('d.m.Y'),
            'position' => $request->query('position'),
        ]);

        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);

        $doc = new dokumente();
        $doc->name = 'Notarztvertrage';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 16;
        $doc->path = $name;
        $doc->save();

        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);
    }
    public function navertragohne(Request $request){

        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $pdf = Pdf::loadView('intranet.vorlagen.notarztvertragohne', [
            'mitarbeiter' => $request->query('name'),
            'verwalter' => $request->query('verwalter'),
            'datum2' => Carbon::today()->format('d.m.Y'),
            'position' => $request->query('position'),
        ]);

        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);



        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);
    }

}

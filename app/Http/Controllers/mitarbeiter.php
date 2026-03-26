<?php

namespace App\Http\Controllers;

use App\Models\dokumente;
use App\Models\dokumententyp;
use App\Models\Eintrage;
use App\Models\lager;
use App\Models\raenge;
use App\Models\stempeluhr;
use App\Models\urlaub;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class mitarbeiter extends Controller
{
    public function mitarbeiter()
    {
        $mitarbeiter = \App\Models\Mitarbeiter::all()->sortBy('dienstnummer');

        return view('intranet.verwaltung.mitarbeiter.mitarbeiter', compact('mitarbeiter'));
    }

    public function archiv()
    {
        $mitarbeiter = \App\Models\Mitarbeiter::all();
        $dienstgrade = raenge::all();

        return view('intranet.verwaltung.mitarbeiter.archiv', compact('mitarbeiter', 'dienstgrade'));
    }
    public function inaktiv()
    {
        $mitarbeiters = \App\Models\Mitarbeiter::all();
        $mitarbeiter = [];

        foreach ($mitarbeiters as $mitarbeitere) {
            $stempeluhrs = stempeluhr::where('created_at', '>', Carbon::now()->subDays(60))->where('user_id', $mitarbeitere->id)->get();

            if (count($stempeluhrs) == 0) {
                array_push($mitarbeiter, $mitarbeitere);
            }
        }
        $dienstgrade = raenge::all();

        return view('intranet.verwaltung.mitarbeiter.inaktive', compact('mitarbeiter', 'dienstgrade'));
    }

    public function view(Request $request, $id){
        $mitarbeiter = \App\Models\Mitarbeiter::find($id);
        $logs = stempeluhr::where('user_id', $mitarbeiter->id)->orderBy('created_at')->get();
        $totalSeconds = 0;
        foreach ($logs as $entry) {
            if ($entry["end_time"] != null)
            {
                $start = strtotime($entry["start_time"]);
                $end = strtotime($entry["end_time"]);
                $totalSeconds += ($end - $start);
            }

        }
        $days = floor($totalSeconds / 86400);
        $totalSeconds -= $days * 86400;
        $hours = floor($totalSeconds / 3600);
        $totalSeconds = $totalSeconds - ($hours*3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $eintraege = Eintrage::where('user_id', $mitarbeiter->id)->get();

        $monate = stempeluhr::where('user_id', $mitarbeiter->id)
            ->select(DB::raw("DATE_FORMAT(start_time, '%Y-%m') as monat"))
            ->groupBy('monat')
            ->orderBy('monat', 'desc')
            ->get()
            ->pluck('monat')
            ->map(function($monat) {
                return [
                    'wert' => $monat,
                    'anzeige' => \Carbon\Carbon::createFromFormat('Y-m', $monat)->translatedFormat('F Y')
                ];
            });

        $lagermonate = lager::where('user_id', $mitarbeiter->id)
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as monat"))
            ->groupBy('monat')
            ->orderBy('monat', 'desc')
            ->get()
            ->pluck('monat')
            ->map(function($lagermonat) {
                return [
                    'wert' => $lagermonat,
                    'anzeige' => \Carbon\Carbon::createFromFormat('Y-m', $lagermonat)->translatedFormat('F Y')
                ];
            });

        $aktuellerMonat = $request->get('monat', Carbon::now()->format('Y-m'));
        $lagerMonat = $request->input('lagerMonat', Carbon::now()->format('Y-m'));
        $start = Carbon::createFromFormat('Y-m', $lagerMonat)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $eintraegestempeluhr = stempeluhr::where('user_id', $mitarbeiter->id)
            ->whereYear('start_time', substr($aktuellerMonat, 0, 4))
            ->whereMonth('start_time', substr($aktuellerMonat, 5, 2))
            ->orderBy('start_time')
            ->get();

        $tageMitZeiten = [];

        foreach ($eintraegestempeluhr as $eintrag) {
            if ($eintrag->end_time) {
                $datum = Carbon::parse($eintrag->start_time)->toDateString();
                $dauer = strtotime($eintrag->end_time) - strtotime($eintrag->start_time);

                if (!isset($tageMitZeiten[$datum])) {
                    $tageMitZeiten[$datum] = 0;
                }
                $tageMitZeiten[$datum] += $dauer;
            }
        }

        $tageMitZeiten = collect($tageMitZeiten)->map(function($sekunden) {
            $stunden = floor($sekunden / 3600);
            $minuten = floor(($sekunden % 3600) / 60);
            return sprintf('%02d:%02d Std.', $stunden, $minuten);
        });

        $typen = dokumententyp::all();
        $dokumente = dokumente::where('user_id', $mitarbeiter->id)->get();

        $lager= lager::where('user_id', $mitarbeiter->id)->get();

        $schrankLogs = Lager::where('user_id', $mitarbeiter->id)
            ->whereBetween('created_at', [$start, $end])
            ->orderByDesc('created_at')
            ->get();

        $urlaub = urlaub::where('user_id', $mitarbeiter->id)->get();



        return view('intranet.verwaltung.mitarbeiter.view', compact('mitarbeiter', 'hours', 'minutes', 'days', 'eintraege', 'monate', 'aktuellerMonat', 'eintraegestempeluhr', 'tageMitZeiten', 'typen', 'dokumente', 'logs', 'lager', 'schrankLogs', 'lagermonate', 'urlaub'));
    }



    public function neweintrag(Request $request, $id){

        $validatet = $request->validate([
            'titel' => 'required|string',
            'value' => 'required|string',
        ]);

        $eintrag = new Eintrage();
        $eintrag->user_id = $id;
        $eintrag->head = $validatet['titel'];
        $eintrag->value = $validatet['value'];
        $eintrag->save();
        return back()->with('msg', 'Eintrag wurde erfolgreich erstellt!');
    }

    public function editeintrag(Request $request, $id){
        $validatet = $request->validate([
            'titel' => 'required|string',
            'value' => 'required|string',
        ]);

        $eintrag = Eintrage::find($id);
        $eintrag->head = $validatet['titel'];
        $eintrag->value = $validatet['value'];
        $eintrag->save();

        return back()->with('msg', 'Eintrag wurde erfolgreich aktualisiert!');
    }

    public function deleteeintrag(Request $request, $id){
        $eintrag = Eintrage::find($id);
        $eintrag->delete();
        return back()->with('msg', 'Eintrag erfolgreich gelöscht!');
    }

    public function newdokument(Request $request, $id)
    {
        $validatet = $request->validate([
            'dokumentenname' => 'required|string',
            'dokumententyp' => 'required|integer',
            'file' => 'required|file',
        ]);

        $doc = new dokumente();
        $doc->name = $validatet['dokumentenname'];
        $doc->user_id = $id;
        $doc->type = $validatet['dokumententyp'];

        if ($request->hasFile('file')) {
            $filename = time() . '.' . $request->file('file')->extension();
            $request->file('file')->move(public_path('dokumente'), $filename);
            $doc->path = $filename;
        }

        $doc->save();
        return back()->with('msg', 'Dokument erfolgreich erstellt!');

    }

    public function downloaddokument(Request $request, $id)
    {
        $doc = dokumente::find($id);
        return response()->download(public_path('dokumente/' . $doc->path));
    }

    public function viewdokument(Request $request, $id)
    {
        $doc = dokumente::find($id);
        return response()->file(public_path('dokumente/' . $doc->path));
    }

    public function viewdoc(Request $request, $id){
        return response()->file(public_path('dokumente/' . $id));
    }

    public function deletedokument(Request $request, $id)
    {
        $doc = dokumente::find($id);
        File::delete(public_path('dokumente/' . $doc->path));
        $doc->delete();
        return back()->with('msg', 'Dokument gelöscht!');
    }

    public function edit(Request $request, $id)
    {
        $mitarbeiter = \App\Models\Mitarbeiter::find($id);
        $raenge = raenge::all();
        return view('intranet.verwaltung.mitarbeiter.edit', compact('mitarbeiter', 'raenge'));
    }
    public function new()
    {
        $raenge = raenge::all();
        return view('intranet.verwaltung.mitarbeiter.new', compact('raenge'));
    }
    public function change(Request $request, $id){
        $validatet = $request->validate([
            'name' => 'required|string',
            'geburtsdatum' => 'required|string',
            'aktiv' => 'required|boolean',
            'arbeitsverhältnis' => 'required|string',
            'dienstnummer' => 'required|integer',
            'telefonnummer' => 'required|integer',
            'iban' => 'string',
            'beamtenstatus' => 'required|string',
            'nbz' => 'required|boolean',
            'nebenjob' => 'string',
            'nebenjob_von' => 'string',
        ]);
        $mitglied = \App\Models\Mitarbeiter::find($id);

        $mitglied->name = $validatet['name'];
        $mitglied->geburtsdatum = $validatet['geburtsdatum'];
        $mitglied->aktiv = $validatet['aktiv'];
        $mitglied->arbeitsverhaltnis = $validatet['arbeitsverhältnis'];
        $mitglied->dienstnummer = $validatet['dienstnummer'];
        $mitglied->telefonnummer = $validatet['telefonnummer'];
        1;
        $mitglied->baeamtenstatus = $validatet['beamtenstatus'];
        $mitglied->zulassung_nebenjob = $validatet['nbz'];
        if ($validatet['nebenjob'] != null and $validatet['nebenjob_von'] != null) {
            $mitglied->nebenjob = $validatet['nebenjob'];
            $mitglied->nebenjob_von = $validatet['nebenjob_von'];
        } else{
            $mitglied->nebenjob = 'n.A.';
            $mitglied->nebenjob_von = 'n.A.';
        }
        $mitglied->save();

        return redirect('/intranet/verwaltung/mitarbeiter/view/'.$mitglied->id);

    }
    public function newm(Request $request){
        $validatet = $request->validate([
            'name' => 'required|string',
            'id'=> 'required|integer',
            'geburtsdatum' => 'required|string',
            'aktiv' => 'required|boolean',
            'arbeitsverhältnis' => 'required|string',
            'dienstnummer' => 'required|integer',
            'telefonnummer' => 'required|integer',
            'iban' => 'string',
            'beamtenstatus' => 'required|string',
            'geschlecht' => 'required|string',
        ]);
        $mitglied = new \App\Models\Mitarbeiter();
        $mitglied->id = $validatet['id'];
        $mitglied->name = $validatet['name'];
        $mitglied->geburtsdatum = $validatet['geburtsdatum'];
        $mitglied->aktiv = $validatet['aktiv'];
        $mitglied->arbeitsverhaltnis = $validatet['arbeitsverhältnis'];
        $mitglied->dienstnummer = $validatet['dienstnummer'];
        $mitglied->telefonnummer = $validatet['telefonnummer'];
        $mitglied->iban =1;
        $mitglied->baeamtenstatus = $validatet['beamtenstatus'];
        $mitglied->zulassung_nebenjob = false;
        $mitglied->dienstgrad = -1;
        $mitglied->naechste_befoerderung = Carbon::now();
        $mitglied->geschlecht = $validatet['geschlecht'];
        $mitglied->nebenjob = 'n.a.';
        $mitglied->nebenjob_von = 'n.a.';
        $mitglied->save();

        return redirect('/intranet/verwaltung/mitarbeiter/view/'.$mitglied->id);

    }

    public function deletem(Request $request, $id){
        $mitarbeiter = \App\Models\Mitarbeiter::find($id);
        $mitarbeiter->delete();
        return redirect('/intranet/verwaltung/mitarbeiter');
    }

    public function bef()
    {
        $mitarbeiter = \App\Models\Mitarbeiter::where('naechste_befoerderung', '<', Carbon::now()->endOfWeek())->get();
        $dienstgrade = raenge::all();
        $stempeluhr = stempeluhr::where('created_at', '>', Carbon::now()->subDays(14))->get();
        return view('intranet.verwaltung.mitarbeiter.befoerderung', compact('mitarbeiter', 'dienstgrade', 'stempeluhr'));
    }

    public function befnew(Request $request)
    {
        $validated = $request->validate([
            'mitarbeiter_ids' => 'required|array',
        ]);

        $webhookurl = env('DISCORD_WEBHOOK_BEFOERDERUNG');

        $beförderungenText = '';
        foreach ($validated['mitarbeiter_ids'] as $discordId) {
            $mitarbeiter = \App\Models\Mitarbeiter::find($discordId);
            $raenge = raenge::all();
            foreach ($raenge as $rang) {
                if($rang->id == $mitarbeiter->dienstgrad){
                    foreach ($raenge as $next) {
                        if($next->id == $rang->next_rang){
                            $beförderungenText .= "<@{$discordId}> zu **{$next->name}**\n";
                        }
                    }
                }
            }

        }
        $currentWeek = Carbon::now()->week;

        $message = <<<EOT
            **Hiermit veröffentlichen wir die Beförderungen für die Kalender Woche {$currentWeek}**

            Hier sind die Beförderungen:

            {$beförderungenText}

            **INFORMATION:**
            Um eure Beförderung abzuholen, meldet euch in Rheinstadt bei einem Verwalter!
            Beförderungen können nicht per Ticket ausgestellt werden.

            Wichtig ist auch zu beachten, dass die Beförderungen abgeholt werden müssen.

            Jeder der denkt, er wurde vergessen diesmal, darf gerne ein Ticket erstellen und <@&1070076368064348240> pingen.
            DM Support wird es nicht geben und es wird auch nicht darauf geantwortet.
            Bei Doppel-Beförderungen genau dasselbe bitte.
            Aufgrund der großen Personalmenge können diese Fehler entstehen.
            Wir sehen euch in Rheinstadt.

            Mit freundlichen Grüßen
            <@688076461353074702>
            <@&1070076368064348240>

            EOT;

        $response = Http::post($webhookurl, [
            'content' => $message,
        ]);

        if ($response->successful()) {
            return back()->with('msg', 'Erfolgreich gesendet!');
        }

        return back()->with('msg', 'Nachricht nicht erfolgreich gesendet!');
    }

    public function addurlaub(Request $request){
        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $verwalter = \App\Models\Mitarbeiter::find((int) $request->query('genehmigt'));
        $urlaub = new urlaub();
        $urlaub->user_id = (int) $request->query('user_id');
        $urlaub->genehmigt = $verwalter->name;
        $urlaub->bis = $request->query('bis');
        $urlaub->save();

        return response()->json(['success' => true], 200);
    }
}

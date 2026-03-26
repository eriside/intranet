<?php

namespace App\Http\Controllers;

use App\Models\changelog;
use App\Models\dokumententyp;
use App\Models\raenge;
use App\Models\Role;
use App\Models\todos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class intranet extends Controller
{



    public function todo(){
        $todos = todos::orderBy('position')->get();
        return view('intranet.leitung.todo',compact('todos'));
    }
    public function todonew(Request $request)
    {
        $validatedData = $request->validate(['description' => 'required']);

        $maxPosition = todos::max('position') ?? 0;

        $aufgabe = new todos();
        $aufgabe->description = $validatedData['description'];
        $aufgabe->status = 'offen';
        $aufgabe->position = $maxPosition + 1;
        $aufgabe->save();

        return back()->with('msg', 'Erfolgreich angelegt!');
    }

    public function tododelete(Request $request, $id)
    {
        $aufgabe = todos::find($id);
        if ($aufgabe) {
            $aufgabe->delete();

            $todos = todos::orderBy('position')->get();
            foreach ($todos as $index => $todo) {
                $todo->position = $index + 1;
                $todo->save();
            }
        }

        return back()->with('msg', 'Erfolgreich gelöscht!');
    }

    public function todoupdate(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:offen,In Arbeit,Erledigt',
        ]);
        $aufgabe = todos::find($id);
        $aufgabe->status = $validated['status'];
        $aufgabe->save();
        return back()->with('msg', 'Erfolgreich geändert');
    }
    public function todoreorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            todos::where('id', $item['id'])->update(['position' => $item['position']]);
        }

        return back()->with('msg', 'Erfolgreich geändert');
    }

    public function changelog()
    {
        $changelogs = changelog::all()->sortByDesc('created_at');
        return view('intranet.leitung.changelog', compact('changelogs'));
    }
    public function changelognew(Request $request)
    {
        $validated = $request->validate([
            'titel' => 'required|string|max:256',
            'allgemein' => 'nullable|string',
            'dev' => 'nullable|string',
            'fuhr' => 'nullable|string',
            'fw' => 'nullable|string',
            'rd' => 'nullable|string',
            'personal' => 'nullable|string',
        ]);

        $changelog = new changelog();
        $changelog->titel = $validated['titel'];
        $changelog->allgemein = $validated['allgemein'];
        $changelog->dev = $validated['dev'];
        $changelog->fuhr = $validated['fuhr'];
        $changelog->fw = $validated['fw'];
        $changelog->rd = $validated['rd'];
        $changelog->personal = $validated['personal'];
        $changelog->save();

        $fieldMappings = [
            'allgemein' => "Allgemein:",
            'dev' => "Ehrenamt:",
            'fuhr' => "Fuhrpark:",
            'fw' => "PSNV:",
            'rd' => "Rettungsdienst:",
            'personal' => "Personal:"
        ];

        $allFields = [];

        foreach ($fieldMappings as $key => $title) {
            if (!empty($validated[$key])) {
                $content = $validated[$key];
                // Split into chunks of max 1024 characters
                $chunks = str_split($content, 1024);
                foreach ($chunks as $i => $chunk) {
                    $fieldTitle = $i === 0 ? $title : $title . ' (Fortsetzung)';
                    $allFields[] = [
                        'name' => $fieldTitle,
                        'value' => $chunk,
                        'inline' => false
                    ];
                }
            }
        }

        // Create multiple embeds if needed (max 6000 chars and 25 fields per embed)
        $embeds = [];
        $currentEmbed = [
            'title' => $validated['titel'],
            'color' => 7506394,
            'thumbnail' => [
                'url' => "https://krd.nuscheltech.de/images/stadtwappen2.webp",
            ],
            'fields' => []
        ];
        $charCount = strlen($validated['titel']);

        foreach ($allFields as $field) {
            $fieldSize = strlen($field['name']) + strlen($field['value']);
            $fieldCount = count($currentEmbed['fields']);

            if (($charCount + $fieldSize > 5900) || $fieldCount >= 25) {
                $embeds[] = $currentEmbed;
                $currentEmbed = [
                    'title' => '', // Nur erster Embed hat Titel
                    'color' => 7506394,
                    'fields' => []
                ];
                $charCount = 0;
            }

            $currentEmbed['fields'][] = $field;
            $charCount += $fieldSize;
        }

        if (!empty($currentEmbed['fields'])) {
            $embeds[] = $currentEmbed;
        }

        if (!empty($embeds)) {
            Http::post(env('DISCORD_WEBHOOK_INTRANET_EMBEDS'), [
                'content' => '',
                'embeds' => $embeds
            ]);
        }

        return back()->with('msg', 'Erfolgreich angelegt!');
    }

    public function berechtigungen()
    {

        $users = User::all();
        $rollen = Role::all();
        $namen = \App\Models\Mitarbeiter::all();
        return view('intranet.administration.berechtigungen', compact('users', 'rollen', 'namen'));
    }

    public function edituserroles(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'options'   => 'nullable|array',
            'options.*' => 'integer|exists:roles,id',
        ]);

        // Wenn keine Optionen gesendet wurden (also alle abgewählt), ist 'options' null → leeres Array übergeben
        $user->roles()->sync($validated['options'] ?? []);

        return back()->with('msg', 'Rollen erfolgreich gesetzt!');
    }


    public function raenge()
    {

        $raenge = raenge::all();

        return view('intranet.administration.raenge', compact('raenge'));
    }
    public function raengenew(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
            'rang' => 'required|integer',
            'gehalt' => 'required|integer',
            'discord_id' => 'required|integer',
        ]);
        $raenge = new raenge();
        $raenge->name = $validated['name'];
        $raenge->next_rang = $validated['rang'];
        $raenge->time_till = $validated['time'];
        $raenge->gehalt = $validated['gehalt'];
        $raenge->discord_id = $validated['discord_id'];
        $raenge->save();
        return back()->with('msg', 'Erfolgreich angelegt!');
    }
    public function editraenge(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string',
            'time' => 'required|integer',
            'rang' => 'required|integer',
            'gehalt' => 'required|integer',
            'discord_id' => 'required|integer',
        ]);
        $rang = raenge::find($id);
        $rang->name = $validated['name'];
        $rang->next_rang = $validated['rang'];
        $rang->time_till = $validated['time'];
        $rang->gehalt = $validated['gehalt'];
        $rang->discord_id = $validated['discord_id'];
        $rang->save();

        return back()->with('msg', 'Rangen erfolgreich geändert!');
    }
    public function deleteraenge(Request $request, $id)
    {
        $rang = raenge::find($id);
        $rang->delete();

        return back()->with('msg', 'Rang erfolreich gelöscht!');
    }

    public function dokumententyp()
    {

        $arten = dokumententyp::all();

        return view('intranet.administration.dokumententyp', compact('arten'));
    }

    public function deletedokumententyp(Request $request, $id)
    {
        $typ = dokumententyp::find($id);
        $typ->delete();

        return back()->with('msg', 'Erfolgreich gelöscht!');
    }

    public function editdokumententyp(Request $request, $id){
        $validated = $request->validate([
            'art' => 'required|string',
        ]);


        $typ = dokumententyp::find($id);
        $typ->art = $validated['art'];
        $typ->save();

        return back()->with('msg', 'Erfolgreich gespeichert!');
    }

    public function dokumententypnew(Request $request)
    {
        $validated = $request->validate([
            'art' => 'required|string',
        ]);

        $typ = new dokumententyp();
        $typ->art = $validated['art'];
        $typ->save();
        return back()->with('msg', 'Erfolgreich angelegt!');
    }

    public function adduser(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'options' => 'required|array',
            'options.*' => 'integer|exists:roles,id',
        ]);
        $user = new User();
        $user->id = $validated['id'];
        $user->username = $validated['name'];
        $user->locale = 'de';
        $user->mfa_enabled = false;
        $user->save();
        $user->roles()->sync($validated['options']);

        return back()->with('msg', 'Erfolgreich angelegt!');

    }


}

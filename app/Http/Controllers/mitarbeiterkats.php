<?php

namespace App\Http\Controllers;

use App\Models\dokumente;
use App\Models\dokumentekats;
use App\Models\dokumententyp;
use App\Models\Eintrage;
use App\Models\lager;
use App\Models\mitarbeiterkatschutz;
use App\Models\raenge;
use App\Models\stempeluhr;
use App\Models\urlaub;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



class mitarbeiterkats extends Controller
{
    public function mitarbeiter()
    {
        $mitarbeiter = \App\Models\mitarbeiterkatschutz::all()->sortBy('dienstnummer');
        $dienstgrade = raenge::all();

        return view('intranet.kats.mitarbeiter.mitarbeiter', compact('mitarbeiter', 'dienstgrade'));
    }

    public function archiv()
    {
        $mitarbeiter = \App\Models\Mitarbeiter::all();
        $dienstgrade = raenge::all();

        return view('intranet.kats.mitarbeiter.archiv', compact('mitarbeiter', 'dienstgrade'));
    }


    public function view(Request $request, $id){
        $mitarbeiter = \App\Models\mitarbeiterkatschutz::find($id);
        $typen = dokumententyp::all();
        $dokumente = dokumentekats::where('user_id', $mitarbeiter->id)->get();


        return view('intranet.kats.mitarbeiter.view', compact('mitarbeiter', 'typen', 'dokumente'));
    }

    public function newdokument(Request $request, $id)
    {
        $validatet = $request->validate([
            'dokumentenname' => 'required|string',
            'dokumententyp' => 'required|integer',
            'file' => 'required|file',
        ]);

        $doc = new dokumentekats();
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
        $doc = dokumentekats::find($id);
        return response()->download(public_path('dokumente/' . $doc->path));
    }

    public function viewdokument(Request $request, $id)
    {
        $doc = dokumentekats::find($id);
        return response()->file(public_path('dokumente/' . $doc->path));
    }

    public function viewdoc(Request $request, $id){
        return response()->file(public_path('dokumente/' . $id));
    }

    public function deletedokument(Request $request, $id)
    {
        $doc = dokumentekats::find($id);
        File::delete(public_path('dokumente/' . $doc->path));
        $doc->delete();
        return back()->with('msg', 'Dokument gelöscht!');
    }




    public function edit(Request $request, $id)
    {
        $mitarbeiter = \App\Models\mitarbeiterkatschutz::find($id);
        $raenge = raenge::all();
        return view('intranet.kats.mitarbeiter.edit', compact('mitarbeiter', ));
    }
    public function new()
    {
        return view('intranet.kats.mitarbeiter.new', );
    }
    public function change(Request $request, $id){
        $validatet = $request->validate([
            'name' => 'required|string',
            'vorname' => 'required|string',
            'geburtsdatum' => 'required|string',
            'aktiv' => 'required|boolean',
            'email' => 'required|string',
            'telefonnummer' => 'required|integer',
            'iban' => 'string',
            'geschlecht' => 'required|string',
            'führerscheinklassen' => 'required|string',
        ]);

        $mitglied = \App\Models\mitarbeiterkatschutz::find($id);

        $mitglied->name = $validatet['name'];
        $mitglied->vorname = $validatet['vorname'];
        $mitglied->geburtsdatum = $validatet['geburtsdatum'];
        $mitglied->aktiv = $validatet['aktiv'];
        $mitglied->email = $validatet['email'];
        $mitglied->telefonnummer = $validatet['telefonnummer'];
        1;
        $mitglied->geschlecht = $validatet['geschlecht'];
        $mitglied->führerscheinklassen  = $validatet['führerscheinklassen'];


        $mitglied->save();



        return redirect('/intranet/kats/mitarbeiter/view/'.$mitglied->id);

    }
    public function newm(Request $request){
        $validatet = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'vorname' => 'required|string',
            'geburtsdatum' => 'required|string',
            'aktiv' => 'required|boolean',
            'email' => 'required|string',
            'telefonnummer' => 'required|integer',
            'iban' => 'string',
            'geschlecht' => 'required|string',
            'führerscheinklassen' => 'required|string',
        ]);


        $mitglied = new mitarbeiterkatschutz();

        $mitglied->id = $validatet['id'];
        $mitglied->name = $validatet['name'];
        $mitglied->vorname = $validatet['vorname'];
        $mitglied->geburtsdatum = $validatet['geburtsdatum'];
        $mitglied->aktiv = $validatet['aktiv'];
        $mitglied->email = $validatet['email'];
        $mitglied->telefonnummer = $validatet['telefonnummer'];
        1;
        $mitglied->geschlecht = $validatet['geschlecht'];
        $mitglied->führerscheinklassen  = $validatet['führerscheinklassen'];

        $mitglied->save();

        return redirect('/intranet/kats/mitarbeiter/view/'.$mitglied->id);

    }

    public function deletem(Request $request, $id){
        $mitarbeiter = \App\Models\mitarbeiterkatschutz::find($id);
        $mitarbeiter->delete();
        return redirect('/intranet/kats/mitarbeiter');
    }

    public function vertrag(Request $request){


        $apiKey = $request->header('X-API-Key');

        if ($apiKey !== env('INTRANET_API_KEY')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $pdf = Pdf::loadView('intranet.vorlagen.katsbogen', [
            'name' => $request->query('name'),
            'vorname' => $request->query('vorname'),
            'datum' => $request->query('geburtsdatum'),
            'email' => $request->query('email'),
            'nummer' => $request->query('telefonnummer'),
            'iban' => 1,
            'geschlecht' => $request->query('geschlecht'),
            'führerscheinklassen' => $request->query('führerscheinklassen'),
            'verwalter' => $request->query('verwalter'),
            'arbeitgeber' => $request->query('arbeitgeber'),

        ]);

        $mitglied = new mitarbeiterkatschutz();

        $mitglied->id = $request->query('user_id');
        $mitglied->name = $request->query('name');
        $mitglied->vorname = $request->query('vorname');
        $mitglied->geburtsdatum = $request->query('geburtsdatum');
        $mitglied->aktiv = true;
        $mitglied->email = $request->query('email');
        $mitglied->telefonnummer = $request->query('telefonnummer');
        $mitglied->iban = 1;
        $mitglied->geschlecht = $request->query('geschlecht');
        $mitglied->führerscheinklassen  = $request->query('führerscheinklassen');

        $mitglied->save();

        $pdf->setPaper('A4', 'portrait');
        $name = time().'.pdf';
        $path = public_path('dokumente/'.$name);
        $pdf->save($path);

        $doc = new dokumentekats();
        $doc->name = 'Personalbogen';
        $doc->user_id = (int) $request->query('user_id');
        $doc->type = 4;
        $doc->path = $name;
        $doc->save();

        return response()->json(['success' => true, 'message' => url('/file/'.$name)]);


    }



}

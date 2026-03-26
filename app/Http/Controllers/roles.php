<?php

namespace App\Http\Controllers;

use App\Models\funktionen;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class roles extends Controller
{
    public function rollen()
    {
        $funktionen = funktionen::all();
        $berechtigungen = Role::all();

        $botToken = config('services.discord.bot_token');;
        $guildId = 1058946637113864232;
        $response = Http::withHeaders([
            'Authorization' => 'Bot ' . $botToken,
        ])->get("https://discord.com/api/v10/guilds/{$guildId}/roles");



        $rollenListe = collect($response->json())->keyBy('id');


        foreach ($funktionen as $funktion) {
            $rollenRaw = $funktion->discord_roles;

            $rollenIds = is_string($rollenRaw)
                ? json_decode($rollenRaw, true)
                : (is_array($rollenRaw) ? $rollenRaw : []);

            $funktion->discord_roles_data = collect($rollenIds)->map(function ($id) use ($rollenListe) {
                return [
                    'id' => $id,
                    'name' => $rollenListe[(int) $id]['name'] ?? "Unbekannte Rolle ($id)",
                ];
            });
        }


        return view('intranet.administration.rollen', compact("funktionen", 'berechtigungen'));
    }

    public function addrole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'discord_roles' => 'array',
            'options' => 'required|array',
            'options.*' => 'integer|exists:roles,id',
        ]);

        $role = new funktionen();
        $role->name= $validated['name'];
        $role->berechtigungen = $validated['options'];
        $role->discord_roles = $validated['discord_roles'];
        $role->save();
        return back()->with('msg', 'Rolle Erfolgreich hinzugefügt!');
    }

    public function editrole(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required|string',
            'discord_roles' => 'array',
            'options' => 'required|array',
            'options.*' => 'integer|exists:roles,id',
        ]);

        $funktionen = funktionen::find($id);
        $funktionen->name= $validated['name'];
        $funktionen->berechtigungen = $validated['options'];
        $funktionen->discord_roles = $validated['discord_roles'];
        $funktionen->save();

        return back()->with('msg', 'Rolle erfolgreich bearbeitet!');
    }
    public function deleterole(Request $request, $id){
        $funktion = funktionen::find($id);
        $funktion->delete();
        return back()->with('msg', 'Rolle erfolgreich entfernt!');
    }
}

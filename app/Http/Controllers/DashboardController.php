<?php
namespace App\Http\Controllers;

use App\Models\aktuelles;
use App\Models\fuhrpark;
use App\Models\Leitung;
use App\Models\mediafahrzeuge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Get the role of the user from cache or from API.
     *
     * @param string $userId
     * @return array
     */
    private function getUserRoles($userId)
    {
        // Versuche, die Rollen aus dem Cache zu holen
        return Cache::remember("user_roles_{$userId}", now()->addMinutes(60), function() use ($userId) {
            $user = Auth::user();
            return $user->getGuildMember('1058946637113864232')->roles;
        });
    }

    /**
     * Get the user's nickname from cache or from API.
     *
     * @param string $userId
     * @return string|null
     */
    private function getUserNickname($userId)
    {
        // Versuche, den Nickname aus dem Cache zu holen
        return Cache::remember("user_nickname_{$userId}", now()->addMinutes(60), function() use ($userId) {
            $user = Auth::user();
            return $user->getGuildMember('1058946637113864232')->nick;
        });
    }

    /**
     * Check if the user has the required role.
     *
     * @param array $roles
     * @param string $userId
     * @return bool
     */
    private function hasRequiredRoles($roles, $userId)
    {
        return in_array('1058947974388011048', $roles) || in_array('1113881775085735956', $roles) || in_array('1186354361270546523', $roles) || in_array('1070076368064348240', $roles) || $userId == '722885944969134211';
    }
    private function hasRequiredRolesfuhrpark($roles, $userId)
    {
        return in_array('1058947974388011048', $roles) || in_array('1070076368064348240', $roles) || in_array('1113881775085735956', $roles) || $userId == '722885944969134211';
    }

    public function dashboard()
    {
        $user = Auth::user();
        $roles = $this->getUserRoles($user->id);
        $nickname = $this->getUserNickname($user->id);

        if ($this->hasRequiredRoles($roles, $user->id)) {
            return view('dashboard', compact('nickname'));
        }

        return redirect('');
    }

    public function leitung()
    {
        $user = Auth::user();
        $roles = $this->getUserRoles($user->id);
        $nickname = $this->getUserNickname($user->id);

        if ($this->hasRequiredRoles($roles, $user->id)) {
            $leitung = Leitung::all();
            return view('leitungdashboard', compact('leitung', 'nickname'));
        }

        return redirect('');
    }

    public function editLeitung(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $mitglied = Leitung::find($id);
        $mitglied->rolle = $validated['role'];
        $mitglied->name = $validated['name'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $imageName);
            $mitglied->image = $imageName;
        }

        $mitglied->save();

        return back()->with('msg', 'Nutzer erfolgreich geändert!');
    }

    public function deleteFuhrpark(Request $request, $id)
    {
        $fahrzeug = fuhrpark::find($id);
        $fahrzeug->delete();
        return back()->with('msg', 'Fahrzeug erfolgreich gelöscht!');
    }

    public function newFahrzeug(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fahrzeug = new fuhrpark();
        $fahrzeug->name = $validated['name'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $imageName);
            $fahrzeug->image = $imageName;
        }

        $fahrzeug->save();
        return back()->with('msg', 'Fahrzeug erfolgreich angelegt!');
    }

    public function deleteLeitung(Request $request, $id)
    {
        $mitglied = Leitung::find($id);
        $mitglied->delete();
        return back()->with('msg', 'Benutzer erfolgreich gelöscht!');
    }

    public function newLeitung(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $mitglied = new Leitung();
        $mitglied->name = $validated['name'];
        $mitglied->rolle = $validated['role'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $imageName);
            $mitglied->image = $imageName;
        } else {
            $mitglied->image = 'default.png';
        }

        $mitglied->save();

        return back()->with('msg', 'Mitglied erfolgreich erstellt!');
    }

    public function fuhrpark()
    {
        $user = Auth::user();
        $roles = $this->getUserRoles($user->id);
        $nickname = $this->getUserNickname($user->id);

        if ($this->hasRequiredRolesfuhrpark($roles, $user->id)) {
            $fahrzeuge = fuhrpark::all();
            return view('fuhrparkdashboard', compact('fahrzeuge', 'nickname'));
        }

        return redirect('');
    }

    public function editFuhrpark(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $fahrzeug = fuhrpark::find($id);
        $fahrzeug->name = $validated['name'];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $imageName);
            $fahrzeug->image = $imageName;
        }

        $fahrzeug->save();

        return back()->with('msg', 'Fahrzeug erfolgreich aktualisiert!');
    }

    public function berichte()
    {
        $user = Auth::user();
        $rollen = $this->getUserRoles($user->id);
        $nickname = $this->getUserNickname($user->id);

        foreach ($rollen as $role) {
            if ($role == '1070076368064348240' || $role == '1058947974388011048' || $role == '1186354361270546523' || $user->id == '722885944969134211') {
                $berichte = aktuelles::all()->sortByDesc('einsatzNummer');
                $isleitung = false;
                if($role == '1186355594576273599' || $user->id == '722885944969134211' || $user->id == '366578670426521600'){
                    $isleitung = true;
                }

                $fahrzeuge = mediafahrzeuge::all();

                return view('berichte', compact('berichte', 'nickname', 'fahrzeuge', 'isleitung'));
            }
        }

        return redirect('');
    }
    public function newBerichte(Request $request)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'einsatznummer' => 'required|string|max:255',
            'datum' => 'required|string|max:255',
            'uhrzeit' => 'required|string|max:255',
            'stichwort' => 'required|string|max:255',
            'options' => 'required|array',
            'einsatzlage' => 'required|string|max:255',
            'paragraphs' => 'nullable|array',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $berichte = new aktuelles();
        $berichte->author = $validated['author'];
        $berichte->datum = $validated['datum'];
        $berichte->uhrzeit = $validated['uhrzeit'];
        $berichte->einsatzStichwort = $validated['stichwort'];
        $berichte->eingesetzteFahrzeuge = $validated['options'];
        $berichte->einsatzLage = array_merge([$validated['einsatzlage']], $validated['paragraphs']);
        $berichte->einsatznummer = $validated['einsatznummer'];
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('images'), $imageName);
            $berichte->einsatzBild = $imageName;
        }
        $berichte->save();


        $webhookUrl = env('DISCORD_WEBHOOK_EINSATZBERICHT');
        $imageUrl = asset('storage/images/' . $imageName);
        error_log($imageUrl);

        $embedData = [
            'embeds' => [
                [
                    'title' => 'Einsatz Information',
                    'color' => hexdec('FF5733'),
                    'footer' => [
                        'text' => 'Geschrieben durch '.$validated['author'],
                    ],
                    'fields' => [
                        [
                            'name' => '🚨 Einsatznummer:',
                            'value' => $validated['einsatznummer'],
                            'inline' => false,
                        ],
                        [
                            'name' => '🗓️ Datum:',
                            'value' => $validated['datum'],
                            'inline' => false,
                        ],
                        [
                        'name' => '⏰ Uhrzeit:',
                        'value' => $validated['uhrzeit'].'Uhr',
                        'inline' => false,
                        ],
                        [
                            'name' => '📟 Einsatz Stichwort:',
                            'value' => $validated['stichwort'],
                            'inline' => false,
                        ],
                        [
                            'name' => 'Eingesetzte Fahrzeuge:',
                            'value' => implode("\n", $validated['options']),
                            'inline' => false,
                        ],
                        [
                            'name' => 'Lage:',
                            'value' => implode("\n \n", array_merge([$validated['einsatzlage']], $validated['paragraphs'])),
                            'inline' => false,
                        ],
                    ],
                    'image' => [
                        'url' => env('APP_URL').'/images/'.$imageName, // URL des Bildes
                    ],
                ]
            ],
            'content' => ''
        ];
        error_log(env('APP_URL'));
        $response = Http::post($webhookUrl, $embedData);


        if ($response->successful()) {
            return back()->with('msg', 'Bericht erfolgreich angelegt!');
        }
        return back()->with('msg', 'Fehler bem senden vom Bericht!');


    }

    public function displayImage(Request $request, $filename)
    {
        $path = 'public/images/' . $filename;

        if (!Storage::exists($path)) {
            abort(404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }
    public function newBerichteFahrzeug(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $fahrzeug = new mediafahrzeuge();
        $fahrzeug->name = $validated['name'];
        $fahrzeug->save();
        return back()->with('msg', 'Fahrzeug gespeichert!');
    }
    public function deleteBerichteFahrzeug(Request $request, $id)
    {
        $fahrzeug = mediafahrzeuge::find($id);
        $fahrzeug->delete();
        return back()->with('msg', 'Fahrzeug gelöscht!');
    }
    public function deleteBerichte(Request $request, $id)
    {
        $fahrzeug = aktuelles::find($id);
        $fahrzeug->delete();
        return back()->with('msg', 'Bericht gelöscht!');
    }
}

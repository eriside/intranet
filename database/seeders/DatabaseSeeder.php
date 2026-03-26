<?php

namespace Database\Seeders;

use App\Models\fuhrpark;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use App\Models\Leitung;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $anzahl = 10; // z.B. 10 Datensätze
        $eingesetzteFahrzeuge = ["WLF", "DLK", "KDOW"];
        for ($i = 0; $i < $anzahl; $i++) {
            DB::table('aktuelles')->insert([
                'einsatzNummer' => $faker->unique()->numberBetween(1000, 9999),
                'einsatzStichwort' => $faker->word,
                'einsatzLage' => json_encode([$faker->sentence, $faker->sentence, $faker->sentence, $faker->sentence]),
                'author' => $faker->name,
                'eingesetzteFahrzeuge' => json_encode($eingesetzteFahrzeuge),
                'einsatzBild' => 'image.webp',
                'datum' => $faker->date(),
                'uhrzeit' => $faker->time(),
            ]);
        }

        Leitung::create([
            'name' => 'Max Mustermann',
            'rolle' => 'Direktor der Berufsfeuerwehr',
            'image' => 'default.jpg',
        ]);

        Leitung::create([
            'name' => 'Lisa Beispiel',
            'rolle' => 'Ärztlicher Leiter Rettungsdienst',
            'image' => 'default.jpg',
        ]);

        Leitung::create([
            'name' => 'Hans Muster',
            'rolle' => 'Leitender Branddirektor',
            'image' => 'default.jpg',
        ]);

        Leitung::create([
            'name' => 'Clara Verwaltung',
            'rolle' => 'Verwaltungsleitung',
            'image' => 'default.jpg',
        ]);

        Leitung::create([
            'name' => 'Paul Verwalter',
            'rolle' => 'Verwaltung',
            'image' => 'default.jpg',
        ]);

        fuhrpark::create([
           'name' => 'HLF',
           'image' => 'default.jpg',
        ]);
        fuhrpark::create([
            'name' => 'WLF',
            'image' => 'default.jpg',
        ]);
        fuhrpark::create([
            'name' => 'KDOW',
            'image' => 'default.jpg',
        ]);
    }
}

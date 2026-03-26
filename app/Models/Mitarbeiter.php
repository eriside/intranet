<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitarbeiter extends Model
{
    use HasFactory;
    protected $table = 'mitarbeiters';
    protected $fillable = [
        'id',
        'name',
        'dienstgrad',
        'dienstnummer',
        'naechste_befoerderung',
        'arbeitsverhaltnis',
        'geburtsdatum',
        'geschlecht',
        'telefonnummer',
        'iban',
        'zulassung_nebenjob',
        'nebenjob',
        'nebenjob_von',
        'baeamtenstatus',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mitarbeiterkatschutz extends Model
{
    protected $table = 'mitarbeiterkatschutzs';
    protected $fillable = [
        'id',
        'name',
        'vorname',
        'dienstgrad',
        'geburtsdatum',
        'geschlecht',
        'telefonnummer',
        'iban',
        'email',
        'führerscheinklassen',
    ];
}

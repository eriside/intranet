<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class aktuelles extends Model
{
    use HasFactory;

    protected $table = 'aktuelles';
    protected $casts = [
        'eingesetzteFahrzeuge' => 'array',
        'einsatzLage' => 'array',
    ];
    protected $fillable = [
        'einsatzNummer',
        'einsatzStichwort',
        'einsatzLage',
        'author',
        'eingesetzteFahrzeuge',
        'einsatzBild',
        'datum',
        'uhrzeit',
        'created_at'
    ];
}

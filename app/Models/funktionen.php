<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funktionen extends Model
{
    //
    use HasFactory;
    protected $table = 'funktionens';
    protected $fillable = ['name', 'berechtigungen', 'discord_roles'];
    protected $casts = [
        'berechtigungen' => 'array',
        'discord_roles' => 'array',
    ];
}

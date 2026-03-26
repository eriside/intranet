<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ausbildungen extends Model
{
    protected $table = 'ausbidungens';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'discordID', 'vorher'];
}

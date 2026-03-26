<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class raenge extends Model
{
    use HasFactory;


    protected $table = 'raenges';
    protected $fillable = ['name', 'next_rang', 'time_till', 'discord_id', 'gehalt'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumententyp extends Model
{
    use HasFactory;


    protected $table = 'dokumententyps';
    protected $fillable = ['art'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class zeugnisse extends Model
{
    protected $table = 'zeugnisses';
    protected $fillable = ['ausbildung', 'user_id'];
}

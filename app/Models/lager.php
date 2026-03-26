<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lager extends Model
{
    protected $table = 'lagers';
    protected $fillable = ['user_id', 'value', 'anzahl'];
}

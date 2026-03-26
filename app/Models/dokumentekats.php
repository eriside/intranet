<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumentekats extends Model
{
    protected $table = 'dokumentekats';
    protected $fillable = ['id', 'user_id', 'name', 'path', 'created_at', 'type'];
}

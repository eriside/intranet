<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dokumente extends Model
{
    protected $table = 'dokumente';
    protected $fillable = ['id', 'user_id', 'name', 'path', 'created_at', 'type'];
}

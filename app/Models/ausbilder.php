<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ausbilder extends Model
{
    protected $table = 'ausbilders';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'ausbildungen'];
}

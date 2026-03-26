<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IpLog extends Model
{
    protected $fillable = ['user_id', 'ip', 'route', 'user_agent'];
}

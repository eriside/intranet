<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class changelog extends Model
{
    use HasFactory;
    protected $fillable = ['titel', 'algemein', 'dev', 'fuhr', 'fw', 'rd','rd', 'personal'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

    }
}

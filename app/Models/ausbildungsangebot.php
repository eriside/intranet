<?php

namespace App\Models;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Model;

class ausbildungsangebot extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = self::generateCustomId();
            }
        });
    }

    protected static function generateCustomId()
    {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chars = '';
        for ($i = 0; $i < 6; $i++) {
            $chars .= $alphabet[random_int(0, 25)];
        }
        return substr($chars, 0, 3) . '-' . substr($chars, 3, 3);
    }
}

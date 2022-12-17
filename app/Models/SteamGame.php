<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SteamGame extends Model
{
    use HasFactory;
    
    protected $fillable = [
        // PULLED FROM API
        'appid', //string
        'name', // string
        'playtime', // decimal
        'playtime_2weeks', // decimal

        'owned', // boolean /tinyint for sqlite
    ];
}

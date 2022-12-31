<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SteamGameFillable;
use App\Models\SteamMonthlySnapshot;

class SteamGame extends Model
{
    use HasFactory;
    
    protected $fillable = [
        // PULLED FROM API
        'appid', //string
        'name', // string
        'playtime', // integer
        'playtime_2weeks', // integer

        'owned', // boolean /tinyint for sqlite

        'achievements_achieved', // integer
        'achievements_total', // integer
    ];

    public function fillables() {
        return $this->hasOne(SteamGameFillable::class, 'appid', 'appid');
    }

    public function snapshots() {
        return $this->hasMany(SteamMonthlySnapshot::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

use App\Models\SteamGameFillable;
use App\Models\SteamMonthlySnapshot;
use App\Models\PurchaseRecord;

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

    public function purchaserecords()
    {
        return $this->hasManyThrough(PurchaseRecord::class, SteamGameFillable::class, 'appid', 'appid', 'appid', 'appid');
    }

    /**
    * Get the route key for the model.
    *
    * @return string
    */
    public function getRouteKeyName()
    {
        return 'appid';
    }

}

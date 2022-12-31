<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SteamGame;

class SteamMonthlySnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
    'appid', //string
    'timestamp_year', //smallint
    'timestamp_month', //smallint
    'playtime'
    ];

    public function game() {
        return $this->belongsTo(SteamGame::class, 'appid', 'appid');
    }
}

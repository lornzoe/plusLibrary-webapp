<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SteamGame;

class SteamGameFillable extends Model
{
    use HasFactory;

    protected $fillable = [
        'appid', // string
        
        'cost_initial', // decimal (2plc)
        'cost_additional', // decimal (2plc)
        
        'date_obtained', // date YYYY-MM-DD
        
        'rating', // int but we want to program a constrain from 0/1 to 5 
        'thoughts', // text
        'completed', // bool false default
    ];

    public function game() {
        return $this->belongsTo(SteamGame::class, 'appid', 'appid');
    }
}

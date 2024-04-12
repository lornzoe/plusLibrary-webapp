<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SteamGameFillable;

class PurchaseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appid', // string        
        'desc', //string
        'cost', // decimal
        'is_initial', // boolean
        'date_of_purchase' // YYYY-MM-DD
    ];

    public function fillables() {
        return $this->belongsTo(SteamGameFillable::class, 'appid', 'appid');
    }
}

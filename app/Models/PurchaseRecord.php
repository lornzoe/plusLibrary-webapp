<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PurchaseRecord_TL;

class PurchaseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'appid', // string
        'recordid', // int
        
        'label', //string
        'cost', // decimal
        'dlcmtxflag', // boolean
        'date_obtained' // DD-MM-YYYY
    ];

    public function record_tl()
    {
        return $this->hasOne(PurchaseRecord_TL::class, 'recordid', 'recordid');
    }
}

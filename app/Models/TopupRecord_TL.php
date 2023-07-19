<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopupRecord_TL extends Model
{
    use HasFactory;

    protected $fillable = [
        'tlcost', // decimal
        'sgdcost', // decimal
        'date_obtained', // DD-MM-YYYY
        'tlleftover' //decimal
    ];

}

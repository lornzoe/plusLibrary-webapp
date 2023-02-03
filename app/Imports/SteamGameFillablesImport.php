<?php

namespace App\Imports;

use App\Models\SteamGameFillable;
use Maatwebsite\Excel\Concerns\ToModel;

class SteamGameFillablesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SteamGameFillable([
            //
        ]);
    }
}

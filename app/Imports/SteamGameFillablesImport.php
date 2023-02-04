<?php

namespace App\Imports;

use App\Models\SteamGameFillable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SteamGameFillablesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SteamGameFillable([
            'appid' => $row['appid'],
            'cost_initial' => $row['cost_initial'],
            'date_obtained' => $row['date_obtained'],
            'rating' => $row['rating'],
            'thoughts'=> $row['thoughts'],
            'completed' => $row['completed']
        ]);
    }
}

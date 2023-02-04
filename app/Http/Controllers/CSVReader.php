<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SteamGameFillablesImport;

class CSVReader extends Controller
{
    public function index()
    {
        // a
        return Inertia::render('CSVReader/Index',[
        ]);
    }

    public function upload(Request $request)
    {
        Excel::import(new SteamGameFillablesImport, $request->file);

        return response()->json([
            'success' => true
        ]);
        //return redirect()->route('dashboard')->with('success', 'User Imported Successfully');
        // $request->validate([
        //     'file' => 'required|mimes:csv,txt'
        // ]);

        // $file = $request->file('csv');
        // $data = Excel::load($file, function($reader) {
        //     $reader->sheet(0);
        // });

        // return response()->json($data->toArray());
    }
}

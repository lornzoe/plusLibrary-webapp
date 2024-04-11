<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SteamGameFillablesImport;
// use App\Http\Middleware\VerifyCsrfToken;

use App\Jobs\SteamLibraryPatchSingle_Fillables;
use App\Models\SteamGameFillable;

class CSVReader_SteamFillable extends Controller
{
    
    public function index()
    {
        return Inertia::render('CSVReader_Fillables/Index',[
        ]);
    }

    // public function upload(Request $request)
    // {
    //     Excel::import(new SteamGameFillablesImport, $request->file);

    //     return response()->json([
    //         'success' => true
    //     ]);
    //     //return redirect()->route('dashboard')->with('success', 'User Imported Successfully');
    //     // $request->validate([
    //     //     'file' => 'required|mimes:csv,txt'
    //     // ]);

    //     // $file = $request->file('csv');
    //     // $data = Excel::load($file, function($reader) {
    //     //     $reader->sheet(0);
    //     // });

    //     // return response()->json($data->toArray());
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // let's not bother validating until we will need to in the future
        foreach ($request->all() as $collection)
        {
            // dd($collection);
            foreach ($collection as $container){
                //dd($container);
                //console.log($container);
                // try {
                // $entry = SteamGameFillable::updateOrCreate(
                //     ['appid' => $container['appid']],
                //     [
                //         'cost_initial' => $container['cost_initial'],
                //         'date_obtained' => $container['date_obtained'],
                //         'rating' => $container['rating'], 
                //         'thoughts' => $container['thoughts'],
                //         'completed' => $container['completed'] 
                //     ]
                // );
                // $entry->save();
                // // dd($entry);
                //     }
                //     catch (\Exception $e){
                //         dd($container);
                // }

                 SteamLibraryPatchSingle_Fillables::dispatch($container);

            }
            
        }

        // dd($request->all());

        return redirect(route('fillables.index'));
    }

}

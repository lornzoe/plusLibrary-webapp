<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SteamGameFillablesImport;
// use App\Http\Middleware\VerifyCsrfToken;

use App\Jobs\SteamLibraryCreateSingle_PurchaseRecord;
use App\Jobs\SteamLibraryUpdateCosts_Fillables;

use App\Models\PurchaseRecord;

class CSVReader_PurchaseRecords extends Controller
{
    
    public function index()
    {
        return Inertia::render('CSVReader_Purchases/Index',[
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stack = [];
        // let's not bother validating until we will need to in the future
        foreach ($request->all() as $collection)
        {
            // dd($collection);
            foreach ($collection as $container){
                SteamLibraryCreateSingle_PurchaseRecord::dispatch($container);
                $stack[] = $container['appid'];
            }
            
            foreach (array_unique($stack) as $appid)
            {
                SteamLibraryUpdateCosts_Fillables::dispatch($appid);
            }
        }

        // dd($request->all());

        return redirect(route('purchases.index'));
    }

}

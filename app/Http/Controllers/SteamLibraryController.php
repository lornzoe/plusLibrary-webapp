<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SteamGame;
use Inertia\Inertia;
use App\Jobs\SteamLibraryPull_1;

class SteamLibraryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gamelist = SteamGame::where('playtime_2weeks', '>', 0);

        return Inertia::render('SteamLibrary/Index', [
            'recentgames' => $gamelist->orderBy('playtime_2weeks', 'DESC')->get(), // $recentgames,
            'lastupdate' => $gamelist->orderBy('updated_at', 'DESC')->get()->first() // $lastupdate
        ]);
    }

    public function updateLibrary()
    {
        dispatch(new SteamLibraryPull_1());
        // dd('SteamLibraryPull_1() dispatched');
    }

    public function updateLibraryThroughLink()
    {
        SteamLibraryController::updateLibrary();
        return redirect(route('steamlib.index'));
    }
}

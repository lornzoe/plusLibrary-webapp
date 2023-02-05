<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SteamGame;
use Inertia\Inertia;

class SteamGamesController extends Controller
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
            'recentgames' => SteamGame::with("fillables")->where('playtime_2weeks', '>', 0)->orderBy('playtime_2weeks', 'DESC')->get(), // $recentgames,
            'lastupdate' => SteamGame::where('playtime_2weeks', '>', 0)->orderBy('updated_at', 'DESC')->get()->first() // $lastupdate
        ]);    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SteamGame    $game
     * @return \Illuminate\Http\Response
     */
    public function show(SteamGame $game)
    {
        return Inertia::render('SteamGame/Index',
        [ 
            'game' => $game->load('fillables'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SteamGame    $game
     * @return \Illuminate\Http\Response
     */
    public function edit(SteamGame $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

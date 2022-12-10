<?php

namespace App\Http\Controllers;

use App\Models\SteamGame;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SteamGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('SteamLibrary/Index', [

        ]);
    }

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
     * @param  \App\Models\SteamGame  $steamGame
     * @return \Illuminate\Http\Response
     */
    public function show(SteamGame $steamGame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SteamGame  $steamGame
     * @return \Illuminate\Http\Response
     */
    public function edit(SteamGame $steamGame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SteamGame  $steamGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SteamGame $steamGame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SteamGame  $steamGame
     * @return \Illuminate\Http\Response
     */
    public function destroy(SteamGame $steamGame)
    {
        //
    }
}

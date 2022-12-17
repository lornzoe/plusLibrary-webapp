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
        // get the list of games, sort by first x, show here
        // $recentgames = SteamGame::where('playtime_2weeks', '>', 0)->orderBy('playtime_2weeks', 'DESC')->get();
        // $lastupdate = SteamGame::where('playtime_2weeks', '>', 0)->orderBy('updated_at', 'DESC')->get()->first();

        $gamelist = SteamGame::where('playtime_2weeks', '>', 0);

        return Inertia::render('SteamLibrary/Index', [
            'recentgames' => $gamelist->orderBy('playtime_2weeks', 'DESC')->get(), // $recentgames,
            'lastupdate' => $gamelist->orderBy('updated_at', 'DESC')->get()->first() // $lastupdate
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
        try 
        {
        $url = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=".env("STEAM_APIKEY")."&steamid=".env("STEAM_USERID")."&include_appinfo=true&include_played_free_games=true";
        $rawgamelist = json_decode(file_get_contents($url), true)['response']['games'];
        }
        catch (\Exception $exception)
        {
            // this is assuming there's no connection to Steam.
            // safely stop the job here.
            return redirect(route('steamlib.index'));
        }
        // now iterate through $fullgame with updateorcreate
        
        foreach($rawgamelist as $entry)
        {
            $game = SteamGame::updateOrCreate(
                ['appid' => $entry['appid']],
                [
                    'name' => $entry['name'],
                    'playtime'=> $entry['playtime_forever'],
                    'playtime_2weeks' => isset($entry['playtime_2weeks'])? $entry['playtime_2weeks'] : 0
                ]
            );
        }

        // end 
        return redirect(route('steamlib.index'));

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

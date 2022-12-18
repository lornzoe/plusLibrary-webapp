<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SteamGame;
use App\Jobs\SteamLibraryPullSingle_Achievements;

class DebugPage extends Controller
{
    public function debugCheck()
    {
        // function here
        DebugPage::achTest();

        //
        dd("nothing for debugcheck");
    }

    public function achTest() // test achievement counting
    {
        $appid = '1594940';//'389140'; // horizon chase turbo (should be 24/48 as of writing this) 
        
        $a = 0;
        $t = 0;

        if ($appid == '0') // not properly initialised.
        {
            // error message?
            return;
        }

        $game = SteamGame::where('appid', $appid);

        // check if it exists
        if (!$game->exists())
        {
            // handle game that isn't in database (not necessarily owned, but we can close an eye..?) here.
            dd('achTest appid doesnt exist');
        }

        try
        {
            // api pull here
            $url = "https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=".env("STEAM_APIKEY")."&steamid=".env("STEAM_USERID")."&appid=".$appid;
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true),
                )); // lazy method to protect ourselves from 400 errors (own game, 0 total achs in game)
            $response = json_decode(file_get_contents($url, false, $context),true);

            if (!$response["playerstats"]["success"] || !isset($response["playerstats"]["achievements"])) // if no ach/not owned
            {
                $a = 0;
                $t = 0;
                dd("achtest f ".$appid."; a: ".$a." / t: ".$t);
            }

            $acharray = $response["playerstats"]["achievements"];

            $achieved = 0;
            foreach($acharray as $ach)
            {
                if ($ach['achieved'])
                    $achieved++;
            }
            $a = $achieved;
            $t = count($acharray);
        }
        catch (Exception $exception)
        {
           // handle failed actions (usually no connection to api)
            dd("achtest failed");
        }
        dd("achtest ".$appid."; a: ".$a." / t: ".$t);
    }

    public function basicAndAchTest()
    {
        try 
        {
        $url = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=".env("STEAM_APIKEY")."&steamid=".env("STEAM_USERID")."&include_appinfo=true&include_played_free_games=true";
        $rawgamelist = json_decode(file_get_contents($url), true)['response']['games'];
        }
        catch (Exception $exception)
        {
            // this is assuming there's no connection to Steam.
            // safely stop the job here.
            dd($exception);
        }

        // if we have data, start messing with database
        // query all steam games to be unowned, as we iterate updateOrCreate we set owned to true
        SteamGame::query()->update(['owned' => 0]);
        
        // now iterate through $fullgame with updateorcreate
        foreach($rawgamelist as $entry)
        {
            $game = SteamGame::updateOrCreate(
                ['appid' => $entry['appid']],
                [
                    'name' => $entry['name'],
                    'playtime'=> $entry['playtime_forever'],
                    'playtime_2weeks' => isset($entry['playtime_2weeks'])? $entry['playtime_2weeks'] : 0,

                    'owned' => 1
                ]
            );

            // some extra stuff if game was recently created/ recently played
            if ($game->wasRecentlyCreated || isset($entry['playtime_2weeks']))
            {
                // dispatch steamach job
                $bleh = $entry['appid'];
                //dispatch(new SteamLibraryPullSingle_Achievements($bleh));
                dd('first game that made it here is '.$entry['name']);
            }
        }
    }

    public function dispatchAchTest()
    {
        $appid = '1594940';
        SteamLibraryPullSingle_Achievements::dispatch($appid);
    }
}

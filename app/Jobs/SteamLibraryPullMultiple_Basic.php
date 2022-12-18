<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\SteamGame;
use App\Jobs\SteamLibraryPullSingle_Achievements;

/*
| _1: We're pulling from the API to table steam_games: appid, name, playtime, playtime_2weeks
| 
*/
class SteamLibraryPullMultiple_Basic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
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
            return;
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
                //dispatch steamach job
                SteamLibraryPullSingle_Achievements::dispatch($entry['appid']);
            }
        }
        
        // end 
    }
}
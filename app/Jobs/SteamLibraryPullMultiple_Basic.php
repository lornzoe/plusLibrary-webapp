<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\SteamGame;
use App\Models\SteamGameFillable;
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
        catch (\Exception $e)
        {
            // this is assuming there's no connection to Steam.
            // safely stop the job here.
            fail($e);
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
            // first or create the fillable 
            $gamefillable = SteamGameFillable::firstOrCreate(
                ['appid' => $entry['appid']]
            );
            
            // some extra stuff if game was recently created/ recently played

            // 8/2/2023 -- disabling the 2 week shit because for some reason it's still iterating through all 1k games. not touching it until there's a confirmed fix.
            // 28/6/2023 -- i don't know what's the issue above. maybe bad api call?
            if ($game->wasRecentlyCreated || isset($entry['playtime_2weeks']))
            //if ($game->wasRecentlyCreated)
            {
                //dispatch steamach job
                SteamLibraryPullSingle_Achievements::dispatch($entry['appid']);
            }
        }
        
        // end 
    }
}

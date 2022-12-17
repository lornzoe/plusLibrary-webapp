<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\SteamGame;

/*
| _1: We're pulling from the API to table steam_games: appid, name, playtime, playtime_2weeks
| 
*/
class SteamLibraryPull_1 implements ShouldQueue
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
        // !!! JOB HANDLE IS NOT TESTED.

        $url = "https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=".env("STEAM_APIKEY")."&steamid=".env("STEAM_USERID")."&include_appinfo=true&include_played_free_games=true";
        $rawgamelist = json_decode(file_get_contents($url), true)['response']['games'];

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
    }
}
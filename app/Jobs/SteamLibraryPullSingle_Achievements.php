<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SteamGame;

class SteamLibraryPullSingle_Achievements implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($aappid)
    {
        $this->appid = $aappid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->appid == "0") // not properly initialised.
        {
            // error message?
            return;
        }

        $game = SteamGame::where('appid', $this->appid);

        // check if it exists
        if (!$game->exists())
        {
            // handle game that isn't in database (not necessarily owned, but we can close an eye..?) here.
            return;
        }

        // handle logic here
        try
        {
        // api pull here
        $url = "https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=".env("STEAM_APIKEY")."&steamid=".env("STEAM_USERID")."&appid=".$this->appid;
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true),
            )); // lazy method to protect ourselves from 400 errors (own game, 0 total achs in game)
            $response = json_decode(file_get_contents($url, false, $context),true);

        if (!$response["playerstats"]["success"] || !isset($response["playerstats"]["achievements"])) // if no ach/not owned
        {
            $game->update(["achievements_achieved" => 0]);
            $game->update(["achievements_total" => 0]);
            return;
        }
        
        $acharray = $response["playerstats"]["achievements"];

        $achieved = 0;
        foreach($acharray as $ach)
        {
            if ($ach['achieved'])
                $achieved++;
        }
        $game->update(["achievements_achieved" => $achieved]);
        $game->update(["achievements_total" => count($acharray)]);
        }
        catch (\Exception $e)
        {
            // handle failed actions (usually no connection to api)
            fail($e);
        }

        // end.
    }
}

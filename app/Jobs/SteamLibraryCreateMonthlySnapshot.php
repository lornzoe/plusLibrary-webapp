<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\Models\SteamMonthlySnapshot;
use App\Models\SteamGame;

class SteamLibraryCreateMonthlySnapshot implements ShouldQueue
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
        // grab year/month
        $today = Carbon::now();
        $year = $today->year;
        $month = $today->month;

        if (SteamMonthlySnapshot::where('timestamp_year', $year)
            ->where('timestamp_month', $month)
            ->exists())
        {
            // handle the snapshot existing already
            return; // we already have the snapshot and we don't need it
        }
        
        // basically, iterate through the whole steam_games table and copy over.
        $list = SteamGame::where('owned', true)->get();
        
        foreach ($list as $game)
        {
            $ss = SteamMonthlySnapshot::create(
            [
                'appid' => $game['appid'],
                'playtime' => $game['playtime'],
                'timestamp_month' => $month,
                'timestamp_year' => $year
            ]
            );
        }
        
    }
}

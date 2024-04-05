<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\SteamGameFillable;

class SteamLibraryPatchSingle_Fillables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $container;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($one)
    {
        $this->container = $one;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
        $entry = SteamGameFillable::updateOrCreate(
            ['appid' => $this->container['appid']],
            [
                'cost_initial' => $this->container['cost_initial'],
                'date_obtained' => $this->container['date_obtained'],
                'rating' => $this->container['rating'], 
                'thoughts' => $this->container['thoughts'],
                'completed' => $this->container['completed'] 
            ]
        );
        $entry->save();
        }
        catch (\Exception $e)
        {
            dd($container);
        }
    }
}

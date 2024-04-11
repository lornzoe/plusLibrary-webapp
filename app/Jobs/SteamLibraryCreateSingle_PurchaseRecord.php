<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\PurchaseRecord;

class SteamLibraryCreateSingle_PurchaseRecord implements ShouldQueue
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
        $entry = PurchaseRecord::create(
            [
                'appid' => $this->container['appid'], 
                'desc' => $this->container['desc'],
                'cost' => $this->container['cost'],
                'is_initial' => $this->container['is_initial'],
                'date_of_purchase' => $this->container['date_of_purchase'] 
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

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Jobs\SteamLibraryCreateSingle_PurchaseRecord;
use App\Jobs\SteamLibraryUpdateCosts_Fillables;

class ProcessCSV_PurchaseRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $collection;
    
    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct($one)
    {
        $this->collection = $one;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $stack = [];
        foreach ($this->collection as $container){

            foreach($container as $entry){
                SteamLibraryCreateSingle_PurchaseRecord::dispatch($container);
                $stack[] = $entry["appid"];
            }
        }
        
        foreach (array_unique($stack) as $appid){
            SteamLibraryUpdateCosts_Fillables::dispatch($appid);
        }
    }
}

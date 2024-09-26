<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Jobs\SteamLibraryPatchSingle_Fillables;

class ProcessCSV_Fillables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $collection;

    /**
     * Create a new job instance.
     */
    public function __construct($one)
    {
        //
        $this->collection = $one;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        // dd($this->collection);
        foreach($this->collection as $entry)
        {
            // dd($entry);
            SteamLibraryPatchSingle_Fillables::dispatch($entry);
        }

    }
}

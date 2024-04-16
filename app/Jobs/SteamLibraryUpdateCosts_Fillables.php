<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\SteamGameFillable;

class SteamLibraryUpdateCosts_Fillables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $appid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->appid = $id;
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
            // get the model
            $fillable = SteamGameFillable::where('appid', $this->appid)->first();

            // then we're gonna get the relevant purchase records
            $records = $fillable->purchaserecords;

            // then we'll add up the relevant rows
            $init = 0.00;
            $addit = 0.00;
            foreach($records as $record)
            {
                //$a = $record->getAttribute('is_initial');
                $record->getAttribute('is_initial') ? $init += $record->cost : $addit += $record->cost;
                //$init += $record->cost;
            }

            // then update the fillable with the updated values
            SteamGameFillable::where('appid', $this->appid)->update([
                'cost_initial' => $init,
                'cost_additional' => $addit]
            );
        }
        catch(Exception $e)
        {
            fail($e);
        }
    }
}

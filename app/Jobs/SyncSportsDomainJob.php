<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Kohera\Queries\GetAllDwhSportsQuery;
use App\Sports\Sport;

class SyncSportsDomainJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public function handle(): void
    {
        $existingSports = Sport::all();
        
        $GetAllDwhSportsQuery = new GetAllDwhSportsQuery();

        foreach ($GetAllDwhSportsQuery() as $key => $sport) 
        {
            $sportExists = $existingSports->where('name', $sport->Sport)->isNotEmpty();

            if ($sportExists)
            {
                $existingSports = $existingSports->where('name', "!=", $sport->Sport);

                continue;
            }

            if (!$sportExists) 
            {
                $newSport = new Sport();
                $newSport->name = $sport->Sport;
                $newSport->save();
            }
        }

        foreach ($existingSports as $existingSport) 
        {
            $existingSport->delete();
        }
    }
}

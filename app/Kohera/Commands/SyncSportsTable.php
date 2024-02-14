<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllSports as AllKoheraSports;
use App\Sport\Sport;
use App\Kohera\Sport as koheraSport;
use App\Imports\Sanitizer\Sanitizer;
use App\Sport\Commands\CreateSport;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSportsTable
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingSports = Sport::all();
        $processedSports = [];

        $getAllkoheraSportsQuery = new AllKoheraSports();

        foreach ($getAllkoheraSportsQuery() as $key => $koheraSport) 
        {
            $sanitizer = new Sanitizer();
            $koheraSport = $sanitizer->cleanAllFields($koheraSport);

            if (in_array($koheraSport->Sportkeuze, $processedSports)) 
            {
                continue;
            }

            $sportExists = $existingSports->where('name', $koheraSport->Sportkeuze)->isNotEmpty();

            if ($sportExists)
            {
                $existingSports = $existingSports->where('name', "!=", $koheraSport->Sportkeuze);

                array_push($processedSports, $koheraSport->Sportkeuze);

                continue;
            }

            $this->dispatchSync(new CreateSport($koheraSport));

            array_push($processedSports, $koheraSport->Sportkeuze);
        }

        //sport found in sports table but not in koheraSports
        foreach ($existingSports as $existingSport) 
        {
            $existingSport->delete();
        }
    }
}
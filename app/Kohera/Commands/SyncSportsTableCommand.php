<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllSports as AllKoheraSports;
use App\Sports\Sport;
use App\Kohera\Sport as koheraSport;
use App\Kohera\Purifier\Purifier;
use App\Sports\Commands\CreateNewSportCommand;

final class SyncSportsTableCommand
{
    public function __invoke(): void
    {
        $existingSports = Sport::all();
        $processedSports = [];

        $getAllkoheraSportsQuery = new AllKoheraSports();

        foreach ($getAllkoheraSportsQuery() as $key => $koheraSport) 
        {
            $purifier = new Purifier();
            $koheraSport = $purifier->cleanAllFields($koheraSport);

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

            $createNewSportCommand = new CreateNewSportCommand();
            $createNewSportCommand($koheraSport);

            array_push($processedSports, $koheraSport->Sportkeuze);
        }

        //sport found in sports table but not in koheraSports
        foreach ($existingSports as $existingSport) 
        {
            $existingSport->delete();
        }
    }
}
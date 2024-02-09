<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\GetAllDwhSportsQuery;
use App\Sports\Sport;
use App\Kohera\DwhSport;
use App\Kohera\Purifier\Purifier;
use App\Sports\Commands\CreateNewSportCommand;

class SyncSportsTableCommand
{
    public function __invoke(): void
    {
        $existingSports = Sport::all();
        $processedSports = [];

        $getAllDwhSportsQuery = new GetAllDwhSportsQuery();

        foreach ($getAllDwhSportsQuery() as $key => $dwhSport) 
        {
            $purifier = new Purifier();
            $dwhSport = $purifier->cleanAllFields($dwhSport);

            if (in_array($dwhSport->Sportkeuze, $processedSports)) 
            {
                continue;
            }

            $sportExists = $existingSports->where('name', $dwhSport->Sportkeuze)->isNotEmpty();

            if ($sportExists)
            {
                $existingSports = $existingSports->where('name', "!=", $dwhSport->Sportkeuze);

                array_push($processedSports, $dwhSport->Sportkeuze);

                continue;
            }

            $createNewSportCommand = new CreateNewSportCommand();
            $createNewSportCommand($dwhSport);

            array_push($processedSports, $dwhSport->Sportkeuze);
        }

        //sport found in sports table but not in dwhSports
        foreach ($existingSports as $existingSport) 
        {
            $existingSport->delete();
        }
    }
}
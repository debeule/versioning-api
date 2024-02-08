<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Kohera\Queries\GetAllDwhSportsQuery;
use App\Sports\Sport;
use App\Kohera\DwhSports;
use App\Schools\Commands\CreateNewSportCommand;

class SyncSportsTableCommand
{
    public function __invoke(): void
    {
        $existingSports = Sport::all();

        foreach (DwhSports::all() as $key => $dwhSport) 
        {
            $sportExists = $existingSports->where('name', $dwhSport->Sport)->isNotEmpty();

            if ($sportExists)
            {
                $existingSports = $existingSports->where('name', "!=", $dwhSport->Sport);

                continue;
            }

            if (!$sportExists) 
            {
                $purifier = new Purifier();
                $dwhSport = $purifier->cleanAllFields($dwhSport);

                $createNewSportCommand = new CreateNewSportCommand();
                $createNewSportCommand($dwhSport);
            }
        }

        foreach ($existingSports as $existingSport) 
        {
            $existingSport->delete();
        }
    }
}
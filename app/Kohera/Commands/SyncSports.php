<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllSports as AllKoheraSports;
use App\Sport\Sport;
use App\Kohera\Sport as koheraSport;
use App\Imports\Sanitizer\Sanitizer;
use App\Sport\Commands\CreateSport;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSports
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingSports = Sport::all();
        $processedSports = [];

        $AllkoheraSports = new AllKoheraSports();

        foreach ($AllkoheraSports->get() as $koheraSport) 
        {
            if (in_array($koheraSport->name(), $processedSports)) 
            {
                continue;
            }

            $sportExists = $existingSports->where('name', $koheraSport->name())->isNotEmpty();

            if ($sportExists)
            {
                $existingSports = $existingSports->where('name', "!=", $koheraSport->name());

                array_push($processedSports, $koheraSport->name());

                continue;
            }

            $this->dispatchSync(new CreateSport($koheraSport));

            array_push($processedSports, $koheraSport->name());
        }

        //sport found in sports table but not in koheraSports
        foreach ($existingSports as $existingSport) 
        {
            $existingSport->delete();
        }
    }
}
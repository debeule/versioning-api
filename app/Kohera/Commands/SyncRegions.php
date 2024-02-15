<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\School\Province;
use App\School\Region;
use App\Kohera\Region as KoheraRegion;
use App\Kohera\Queries\AllRegions as AllKoheraRegions;
use App\Imports\Sanitizer\Sanitizer;

use App\School\Commands\CreateRegion;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRegions
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingRegions = Region::all();
        $processedSports = [];
        
        $allKoheraRegions = new AllKoheraRegions();

        foreach ($allKoheraRegions->get() as $koheraRegion) 
        {
            if (in_array($koheraRegion->name(), $processedSports)) 
            {
                continue;
            }

            $regionExists = $existingRegions->where('name', $koheraRegion->name())->isNotEmpty();
            
            if ($regionExists)
            {
                $existingRegions = $existingRegions->where('name', "!=", $koheraRegion->name());

                array_push($processedSports, $koheraRegion->name());
                
                continue;
            }

            $this->dispatchSync(new CreateRegion($koheraRegion));

            array_push($processedSports, $koheraRegion->name());
        }

        //region found in regions but not in koheraregions
        foreach ($existingRegions as $existingRegion) 
        {
            $existingRegion->delete();
        }
    }
}

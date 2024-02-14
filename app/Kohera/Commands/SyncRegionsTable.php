<?php

declare(strict_types=1);

namespace App\Kohera\commands;

use App\School\Province;
use App\School\Region;
use App\Kohera\Region as KoheraRegion;
use App\Kohera\Queries\AllRegions as AllKoheraRegions;
use App\Imports\Sanitizer\Sanitizer;

use App\School\Commands\CreateRegion;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRegionsTable
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingRegions = Region::all();
        $processedSports = [];
        
        $allKoheraRegions = new AllKoheraRegions();

        foreach ($allKoheraRegions() as $key => $koheraRegion) 
        {
            $sanitizer = new Sanitizer();
            $koheraRegion = $sanitizer->cleanAllFields($koheraRegion);

            if (in_array($koheraRegion->RegionNaam, $processedSports)) 
            {
                continue;
            }

            $regionExists = $existingRegions->where('name', $koheraRegion->RegionNaam)->isNotEmpty();
            
            if ($regionExists)
            {
                $existingRegions = $existingRegions->where('name', "!=", $koheraRegion->RegionNaam);

                array_push($processedSports, $koheraRegion->RegionNaam);
                
                continue;
            }

            $this->dispatchSync(new CreateRegion($koheraRegion));

            array_push($processedSports, $koheraRegion->RegionNaam);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Kohera\commands;

use App\Schools\Province;
use App\Schools\Region;
use App\Kohera\Region as KoheraRegion;
use App\Kohera\Queries\AllRegions as AllKoheraRegions;
use App\Kohera\Sanitizer\Sanitizer;

use App\Schools\Commands\CreateNewRegion;

final class SyncRegionsTable
{
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
            
            $createNewRegion = new CreateNewRegion();
            $createNewRegion($koheraRegion);

            array_push($processedSports, $koheraRegion->RegionNaam);
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Schools\Province;
use App\Schools\Region;
use App\Kohera\Region as KoheraRegion;
use App\Kohera\Queries\AllRegions as AllKoheraRegions;
use App\Kohera\Sanitizer\Sanitizer;

use App\Schools\Commands\CreateNewRegionCommand;
use App\Schools\Commands\CreateNewProvinceCommand;

final class SyncRegionsTableCommand
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

            if (!Province::where('name', $koheraRegion->Provincie)->first())
            {
                $createNewProvinceCommand = new CreateNewProvinceCommand();
                $createNewProvinceCommand($koheraRegion);
            }
            
            $createNewRegionCommand = new CreateNewRegionCommand();
            $createNewRegionCommand($koheraRegion);

            array_push($processedSports, $koheraRegion->RegionNaam);
        }
    }
}

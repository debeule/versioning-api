<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Schools\Province;
use App\Schools\Region;
use App\Kohera\DwhRegion;
use App\Kohera\Queries\GetAllDwhRegionsQuery;
use App\Kohera\Purifier\Purifier;

use App\Schools\Commands\CreateNewRegionCommand;
use App\Schools\Commands\CreateNewProvinceCommand;

class SyncRegionsTableCommand
{
    public function __invoke(): void
    {
        $existingRegions = Region::all();
        $processedSports = [];
        
        $getAllDwhRegionsQuery = new GetAllDwhRegionsQuery();

        foreach ($getAllDwhRegionsQuery() as $key => $dwhRegion) 
        {
            $purifier = new Purifier();
            $dwhRegion = $purifier->cleanAllFields($dwhRegion);

            if (in_array($dwhRegion->RegionNaam, $processedSports)) 
            {
                continue;
            }

            $regionExists = $existingRegions->where('name', $dwhRegion->RegionNaam)->isNotEmpty();
            
            if ($regionExists)
            {
                $existingRegions = $existingRegions->where('name', "!=", $dwhRegion->RegionNaam);

                array_push($processedSports, $dwhRegion->RegionNaam);
                
                continue;
            }
            
            $purifier = new Purifier();
            $dwhRegion = $purifier->cleanAllFields($dwhRegion);

            if (!Province::where('name', $dwhRegion->Provincie)->first())
            {
                $createNewProvinceCommand = new CreateNewProvinceCommand();
                $createNewProvinceCommand($dwhRegion);
            }
            
            $createNewRegionCommand = new CreateNewRegionCommand();
            $createNewRegionCommand($dwhRegion);

            array_push($processedSports, $dwhRegion->RegionNaam);
        }
    }
}

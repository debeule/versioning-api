<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Schools\Province;
use App\Schools\Region;
use App\Kohera\DwhRegion;
use App\Kohera\Queries\GetAllDwhRegionsQuery;

use App\Schools\Commands\CreateNewRegionCommand;
use App\Schools\Commands\CreateNewProvinceCommand;

class SyncRegionsTableCommand
{
    public function __invoke(): void
    {
        $existingRegions = Region::all();
        
        foreach (DwhRegion::all() as $key => $DwhRegion) 
        {
            $regionExists = $existingRegions->where('name', $DwhRegion->RegionNaam)->isNotEmpty();
            
            if ($regionExists)
            {
                $existingRegions = $existingRegions->where('name', "!=", $DwhRegion->RegionNaam);

                continue;
            }

            if (!$regionExists) 
            {
                $purifier = new Purifier();
                $dwhRegion = $purifier->cleanAllFields($DwhRegion);

                if (!Province::where('name', $DwhRegion->RegionNaam)->first())
                {
                    $createNewProvinceCommand = new CreateNewProvinceCommand();
                    $createNewProvinceCommand($DwhRegion);
                }
                
                $createNewRegionCommand = new CreateNewRegionCommand();
                $createNewRegionCommand($DwhRegion);
            }
        }
    }
}

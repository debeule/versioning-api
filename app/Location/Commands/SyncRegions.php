<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Queries\RegionDiff;
use App\Location\Region;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRegions
{
    use DispatchesJobs;

    public function __invoke(RegionDiff $regionDiff): void
    {
        foreach ($regionDiff->additions() as $externalRegion) 
        {
            $this->dispatchSync(new CreateRegion($externalRegion));
        }

        foreach ($regionDiff->deletions() as $region) 
        {
            $this->dispatchSync(new SoftDeleteRegion($region));
        }

        foreach ($regionDiff->updates() as $externalRegion) 
        {
            $this->dispatchSync(new SoftDeleteRegion(Region::where('region_number', $koheraRegion->regionNumber())->first()));
            $this->dispatchSync(new CreateRegion($externalRegion));
        }
    }
}
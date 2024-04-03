<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Queries\RegionDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Location\Region;

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
            $this->dispatchSync(new SoftDeleteRegion(Region::where('record_id', $externalRegion->recordId())->first()));
            $this->dispatchSync(new CreateRegion($externalRegion));
        }
    }
}
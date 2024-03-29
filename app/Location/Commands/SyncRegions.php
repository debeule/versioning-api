<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Queries\RegionDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalMunicipalities;

final class SyncRegions
{
    use DispatchesJobs;

    public function __invoke(RegionDiff $regionDiff): void
    {
        foreach ($regionDiff->additions() as $koheraRegion) 
        {
            $this->dispatchSync(new CreateRegion($koheraRegion));
        }

        foreach ($regionDiff->deletions() as $region) 
        {
            $this->dispatchSync(new SoftDeleteRegion($region));
        }

        foreach ($regionDiff->updates() as $koheraRegion) 
        {
            $this->dispatchSync(new SoftDeleteRegion(Region::where('record_id', $koheraRegion->recordId())->first()));
            $this->dispatchSync(new CreateRegion($koheraRegion));
        }
    }
}
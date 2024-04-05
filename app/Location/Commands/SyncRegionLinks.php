<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Queries\RegionLinksDiff;
use App\Location\Region;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRegionLinks
{
    use DispatchesJobs;

    public function __invoke(RegionLinksDiff $regionLinksDiff): void
    {
        foreach ($regionLinksDiff->toLink() as $region) 
        {
            $this->dispatchSync(new LinkRegion($region));
        }
    }
}
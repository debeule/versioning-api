<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Queries\RegionLinksDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRegionLinks
{
    use DispatchesJobs;

    public function __invoke(RegionLinksDiff $regionLinksDiff): void
    {
        foreach ($regionLinksDiff->toLink() as $externalRegion) 
        {
            $this->dispatchSync(new LinkRegion($externalRegion));
        }
    }
}
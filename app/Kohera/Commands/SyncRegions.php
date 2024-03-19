<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllRegions as AllKoheraRegions;
use App\Location\Commands\CreateRegion;
use App\Location\Commands\LinkRegion;
use App\Location\Commands\SoftDeleteRegion;
use App\Location\Queries\AllRegions;

use App\Location\Region;
use App\Services\ProcessImportedRecords;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncRegions
{
    use DispatchesJobs;

    public function __construct(
        private AllKoheraRegions $allKoheraRegions = new AllKoheraRegions(),
        private AllRegions $allRegions = new AllRegions(),
        private RegionByRegionNumber $regionByRegionNumber = new RegionByRegionNumber,
    ) {}
        

    public function __invoke(): void
    {
        $result = ProcessImportedRecords::setup($this->allKoheraRegions->getWithDoubles(), $this->allRegions->get())->pipe();
        
        foreach ($result['update'] as $koheraRegion) 
        {
            $this->dispatchSync(new LinkRegion($koheraRegion));
        }

        foreach ($result['create'] as $koheraRegion) 
        {
            if (!is_null($this->regionByRegionNumber->hasRegionNumber((string) $koheraRegion->regionNumber())->find())) 
            {
                $this->dispatchSync(new CreateRegion($koheraRegion));
            }

            $this->dispatchSync(new LinkRegion($koheraRegion));
        }

        foreach ($result['delete'] as $koheraRegion) 
        {
            $this->dispatchSync(new SoftDeleteRegion($koheraRegion));
        }
    }
}

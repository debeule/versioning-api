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

use Illuminate\Support\Collection;
use App\Location\Municipality;
use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Kohera\Region as KoheraRegion;

use App\Location\Commands\SoftDeleteMunicipality;

final class SyncRegionLinks
{
    use DispatchesJobs;

    public function __construct(
        private AllKoheraRegions $allKoheraRegions = new AllKoheraRegions,
    ) {}
        

    public function __invoke(): void
    {
        $result = $this->regionsToLink();

        foreach ($result['link'] as $koheraRegion) 
        {
            $this->dispatchSync(new LinkRegion($koheraRegion));
        }

        foreach ($result['update'] as $koheraRegion) 
        {
            $this->dispatchSync(new SoftDeleteRegion(Region::where('region_number', $koheraRegion->regionNumber())->first()));
            $this->dispatchSync(new CreateRegion($koheraRegion));
            $this->dispatchSync(new LinkRegion($koheraRegion));
        }
    }

    public function regionsToLink(): Array
    {
        $update = collect();
        $link = collect();

        foreach ($this->allKoheraRegions->getWithDoubles() as $koheraRegion)
        {
            $municipality = Municipality::where('postal_code', $koheraRegion->postalCode())->first();

            if(is_null($municipality)) continue;

            if(!is_null($municipality->region_id))
            {
                if($municipality->region_id === Region::where('region_number', $koheraRegion->recordId())->first()->id) continue;

                if($municipality->region_id !== Region::where('region_number', $koheraRegion->recordId())->first()->id) 
                {
                    $update->push($koheraRegion);
                    continue;
                }
            }
            $link->push($koheraRegion);
        }

        return [
            'update' => $update,
            'link' => $link
        ];
    }
}
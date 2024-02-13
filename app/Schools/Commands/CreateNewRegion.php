<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\Region;
use App\Kohera\Region as KoheraRegion;
use App\Schools\Province;


final class CreateNewRegion
{
    public function __invoke(KoheraRegion $koheraRegion): bool
    {
        if (!$this->recordExists($koheraRegion)) 
        {
            return $this->buildRecord($koheraRegion);
        }

        return true;
    }

    private function recordExists(KoheraRegion $koheraRegion): bool
    {
        return Region::where('region_id', $koheraRegion->RegioDetailId)->exists();
    }

    public function buildRecord(KoheraRegion $koheraRegion): bool
    {
        $newRegion = new Region();

        $newRegion->name = $koheraRegion->RegionNaam;
        $newRegion->province = $koheraRegion->Provincie;
        $newRegion->region_id = $koheraRegion->RegioDetailId;
        
        return $newRegion->save();
    }
}
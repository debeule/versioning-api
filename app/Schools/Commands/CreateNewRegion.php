<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\Region;
use App\Kohera\DwhRegion;
use App\Schools\Province;


final class CreateNewRegion
{
    public function __invoke(DwhRegion $dwhRegion): bool
    {
        if (!$this->recordExists($dwhRegion)) 
        {
            return $this->buildRecord($dwhRegion);
        }

        return true;
    }

    private function recordExists(DwhRegion $dwhRegion): bool
    {
        return Region::where('region_id', $dwhRegion->RegioDetailId)->exists();
    }

    public function buildRecord(DwhRegion $dwhRegion): bool
    {
        $newRegion = new Region();

        $newRegion->name = $dwhRegion->RegionNaam;
        $newRegion->region_id = $dwhRegion->RegioDetailId;
        $newRegion->province = $dwhRegion->Provincie;
        $newRegion->province_id = Province::where('name', $dwhRegion->Provincie)->first()->id;
        
        return $newRegion->save();
    }
}
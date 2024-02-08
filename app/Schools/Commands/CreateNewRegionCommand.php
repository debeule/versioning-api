<?php 

namespace App\Schools\Commands;

use App\Schools\Region;
use App\Kohera\DwhRegion;


final class CreateNewProvinceCommand
{
    public function __invoke(DwhRegion $dwhRegion): bool
    {
        $newRegion = new Region();

        $newRegion->name = $dwhRegion->RegionNaam;
        $newRegion->region_id = $dwhRegion->RegioDetailId;
        $newRegion->province_id = Province::where('name', $dwhRegion->Provincie)->first()->id;
        
        return $newRegion->save();
    }
}
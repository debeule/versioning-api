<?php 

namespace App\Schools\Commands;

use App\Schools\Province;
use App\Kohera\DwhRegio;


final class CreateNewProvinceCommand
{
    public function __invoke(DwhRegio $dwhRegion): bool
    {
        $newProvince = new Province();

        $newProvince->name = $dwhRegion->Provincie;

        return $newProvince->save();
    }
}
<?php 

namespace App\Schools\Commands;

use App\Schools\Municipality;
use App\Kohera\DwhSchool;


final class CreateNewProvinceCommand
{
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        $newMunicipality = new Municipality();

        $newMunicipality->name = $dwhSchool->Gemeente;
        $newMunicipality->postal_code = $dwhSchool->Postcode;

        return $newMunicipality->save();
    }
}
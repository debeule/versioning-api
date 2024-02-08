<?php 

namespace App\Schools\Commands;

use App\Schools\Address;
use App\Kohera\DwhSchool;


final class CreateNewProvinceCommand
{
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        $newAdress = new Address();

        $newAdress->street_name = $addressArray[0];
        $newAdress->street_identifier = $addressArray[1];
        $newAdress->municipality_id = Municipality::where('name', $dwhSchool->Gemeente)->first()->id;

        return $newAdress->save();
    }
}
<?php 

namespace App\Schools\Commands;

use App\Schools\Address;
use App\Kohera\DwhSchool;
use App\Schools\Municipality;


final class CreateNewAddressCommand
{    
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        if (!$this->recordExists($dwhSchool)) 
        {
            return $this->buildRecord($dwhSchool);
        }
        
        if ($this->recordExists($dwhSchool)) 
        {
            return $this->updateRecord($dwhSchool);
        }
    }

    private function recordExists(DwhSchool $dwhSchool): bool
    {
        return Address::where('street_name', explode(' ', $dwhSchool->address)[0])->exists();
    }

    private function buildRecord(DwhSchool $dwhSchool): bool
    {
        $newAdress = new Address();

        $newAdress->street_name = explode(' ', $dwhSchool->address)[0];
        $newAdress->street_identifier = explode(' ', $dwhSchool->address)[1];
        $newAdress->municipality_id = Municipality::where('name', $dwhSchool->Gemeente)->first()->id;

        return $newAdress->save();
    }

    public function updateRecord(DwhSchool $dwhSchool): bool
    {
        $address = Address::where('street_name', explode(' ', $dwhSchool->address)[0])->first();

        $address->street_identifier = explode(' ', $dwhSchool->address)[1];

        return $address->save();
    }
}
<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\Address;
use App\Kohera\KoheraSchool;
use App\Schools\Municipality;


final class CreateAddress
{    
    public function handle(koheraSchool $koheraSchool): bool
    {
        if (!$this->recordExists($koheraSchool)) 
        {
            return $this->buildRecord($koheraSchool);
        }
        
        if ($this->recordExists($koheraSchool) && $this->recordHasChanged($koheraSchool)) 
        {
            return $this->createNewRecordVersion($koheraSchool);
        }
    }

    private function recordExists(KoheraSchool $koheraSchool): bool
    {
        return Address::where('street_name', explode(' ', $koheraSchool->address)[0])->exists();
    }

    private function recordHasChanged(KoheraSchool $koheraSchool): bool
    {
        $address = Address::where('street_name', explode(' ', $koheraSchool->address)[0])->first();

        $recordhasChanged = $address->street_identifier !== explode(' ', $koheraSchool->address)[1];

        return $recordhasChanged;
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {
        $newAdress = new Address();

        $newAdress->street_name = explode(' ', $koheraSchool->address)[0];
        $newAdress->street_identifier = explode(' ', $koheraSchool->address)[1];
        $newAdress->municipality_id = Municipality::where('name', $koheraSchool->Gemeente)->first()->id;

        return $newAdress->save();
    }

    private function createNewRecordVersion(KoheraSchool $koheraSchool): bool
    {
        $address = Address::where('street_name', explode(' ', $koheraSchool->address)[0])->delete();

        return $this->buildRecord($koheraSchool);
    }
}
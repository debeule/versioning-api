<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Address;
use App\Kohera\School as KoheraSchool;
use App\School\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateAddress
{
    use DispatchesJobs;

    public function __construct(
        public KoheraSchool $koheraAddress
    ) {}

    public function handle(): bool
    {
        if (!$this->recordExists($this->koheraAddress)) 
        {
            return $this->buildRecord($this->koheraAddress);
        }
        
        if ($this->recordExists($this->koheraAddress) && $this->recordHasChanged($this->koheraAddress)) 
        {
            return $this->createNewRecordVersion($this->koheraAddress);
        }

        return true;
    }

    private function recordExists(KoheraSchool $koheraAddress): bool
    {
        return Address::where('street_name', $koheraAddress->street_name)->exists();
    }

    private function recordHasChanged(KoheraSchool $koheraAddress): bool
    {
        $address = Address::where('street_name', $koheraAddress->street_name)->first();

        $recordhasChanged = $address->street_identifier !== $koheraAddress->street_identifier;

        return $recordhasChanged;
    }

    private function buildRecord(KoheraSchool $koheraAddress): bool
    {
        $newAdress = new Address();

        $newAdress->street_name = $koheraAddress->street_name;
        $newAdress->street_identifier = $koheraAddress->street_identifier;
        
        $newAdress->municipality_id = Municipality::where('postal_code', $koheraAddress->postal_code)->first()->id;

        return $newAdress->save();
    }

    private function createNewRecordVersion(KoheraSchool $koheraAddress): bool
    {
        $address = Address::where('street_name', $koheraAddress->street_name)->delete();

        return $this->buildRecord($koheraAddress);
    }
}
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
        public KoheraSchool $koheraSchool
    ) {}

    public function handle(): bool
    {
        if (!$this->recordExists($this->koheraSchool)) 
        {
            return $this->buildRecord($this->koheraSchool);
        }
        
        if ($this->recordExists($this->koheraSchool) && $this->recordHasChanged($this->koheraSchool)) 
        {
            return $this->createNewRecordVersion($this->koheraSchool);
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
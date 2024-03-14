<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Address as KoheraAddress;
use App\Location\Municipality;
use App\School\Address;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateAddress
{
    use DispatchesJobs;

    public function __construct(
        public KoheraAddress $koheraAddress
    ) {}

    public function handle(): bool
    {
        if (! $this->recordExists($this->koheraAddress)) 
        {
            return $this->buildRecord($this->koheraAddress);
        }
        
        if ($this->recordHasChanged($this->koheraAddress)) 
        {
            return $this->createNewRecordVersion($this->koheraAddress);
        }

        return false;
    }

    private function recordExists(KoheraAddress $koheraAddress): bool
    {
        return Address::where('record_id', $koheraAddress->recordId())->exists();
    }

    private function recordHasChanged(KoheraAddress $koheraAddress): bool
    {
        $address = Address::where('record_id', $koheraAddress->recordId())->first();

        $recordhasChanged = false;

        $recordhasChanged = $address->street_name !== $koheraAddress->streetName();
        $recordhasChanged = $recordhasChanged || $address->street_identifier !== $koheraAddress->streetIdentifier();

        return $recordhasChanged;
    }

    private function buildRecord(KoheraAddress $koheraAddress): bool
    {
        $newAdress = new Address();
        
        $newAdress->record_id = $koheraAddress->recordId();
        $newAdress->street_name = $koheraAddress->streetName();
        $newAdress->street_identifier = $koheraAddress->streetIdentifier();
        
        $newAdress->municipality_id = Municipality::where('postal_code', $koheraAddress->municipality()->postal_code)->first()->id;

        return $newAdress->save();
    }

    private function createNewRecordVersion(KoheraAddress $koheraAddress): bool
    {
        $address = Address::where('record_id', $koheraAddress->recordId())->delete();

        return $this->buildRecord($koheraAddress);
    }
}
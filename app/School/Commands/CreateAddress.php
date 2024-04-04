<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Imports\Queries\Address;
use App\School\Address as DbAddress;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class CreateAddress
{
    use DispatchesJobs;

    public function __construct(
        public Address $address
    ) {}

    public function handle(): bool
    {
        return $this->buildRecord($this->address)->save();
    }   

    private function buildRecord(Address $address): DbAddress
    {
        $newAdress = new DbAddress();
        
        $newAdress->record_id = $address->recordId();
        $newAdress->street_name = $address->streetName();
        $newAdress->street_identifier = $address->streetIdentifier();
        
        $newAdress->municipality_id = $address->municipality()->id;

        return $newAdress;
    }
}
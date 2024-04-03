<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Queries\AddressDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\School\Address;

final class SyncAddresses
{
    use DispatchesJobs;

    public function __invoke(AddressDiff $addressDiff): void
    {
        foreach ($addressDiff->additions() as $externalAddress) 
        {
            $this->dispatchSync(new CreateAddress($externalAddress));
        }

        foreach ($addressDiff->deletions() as $address) 
        {
            $this->dispatchSync(new SoftDeleteAddress($address));
        }

        foreach ($addressDiff->updates() as $externalAddress) 
        {
            $this->dispatchSync(new SoftDeleteAddress(Address::where('record_id', $externalAddress->recordId())->first()));
            $this->dispatchSync(new CreateAddress($externalAddress));
        }
    }
}
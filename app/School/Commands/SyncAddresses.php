<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\Queries\AddressDiff;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncAddresses
{
    use DispatchesJobs;

    public function __invoke(AddressDiff $addressDiff): void
    {
        foreach ($addressDiff->additions() as $koheraAddress) 
        {
            $this->dispatchSync(new CreateAddress($koheraAddress));
        }

        foreach ($addressDiff->deletions() as $address) 
        {
            $this->dispatchSync(new SoftDeleteAddress($address));
        }

        foreach ($addressDiff->updates() as $koheraAddress) 
        {
            $this->dispatchSync(new SoftDeleteAddress(Address::where('record_id', $koheraAddress->recordId())->first()));
            $this->dispatchSync(new CreateAddress($koheraAddress));
        }
    }
}
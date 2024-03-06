<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Queries\AllAddresses as AllKoheraAddresses;
use App\School\Address;
use App\School\Commands\CreateAddress;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class SyncAddresses
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $existingAddresses = Address::all();
        $processedAddresses = [];

        $allkoheraAddresses = new AllKoheraAddresses();
        
        foreach ($allkoheraAddresses->get() as $koheraAddress) 
        {
            if (in_array($koheraAddress->addressId(), $processedAddresses)) 
            {
                continue;
            }
            
            $this->dispatchSync(new CreateAddress($koheraAddress));
            
            $existingAddresses = $existingAddresses->where('address_id', "!=", $koheraAddress->addressId());

            array_push($processedAddresses, $koheraAddress->addressId());
        }

        //Address found in addresses but not in koheraAddresses
        foreach ($existingAddresses as $existingAddress) 
        {
            $existingAddress->delete();
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Kohera\commands;

use App\School\Address;
use App\Imports\Sanitizer\Sanitizer;
use App\Kohera\Queries\AllAddresses as AllKoheraAddresses;
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
            if (in_array($koheraAddress->streetName(), $processedAddresses)) 
            {
                continue;
            }
            
            $this->dispatchSync(new CreateAddress($koheraAddress));
            
            $existingAddresses = $existingAddresses->where('street_name', "!=", $koheraAddress->streetName());

            array_push($processedAddresses, $koheraAddress->streetName());
        }

        //Address found in sports table but not in koheraAddresses
        foreach ($existingAddresses as $existingAddress) 
        {
            $existingAddress->delete();
        }
    }
}
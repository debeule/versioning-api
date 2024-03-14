<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\School\Commands\CreateAddress;
use App\School\Commands\SoftDeleteAddress;
use App\School\Address;
use Illuminate\Foundation\Bus\DispatchesJobs;

use App\Kohera\Queries\AllAddresses as AllKoheraAddresses;

use App\Services\ProcessImportedRecords;

final class SyncAddresses
{
    use DispatchesJobs;

    public function __construct(
        private AllKoheraAddresses $allKoheraAddresses = new AllKoheraAddresses(),
    ) {}
        

    public function __invoke(): void
    {
        $allAddresses = Address::get();
        $result = ProcessImportedRecords::setup($this->allKoheraAddresses->get(), $allAddresses)->pipe();
        
        foreach ($result['update'] as $Address)
        {
            $this->dispatchSync(new SoftDeleteAddress(Address::where('record_id', $koheraAddress->recordId())->first()));
            $this->dispatchSync(new CreateAddress($Address));
        }

        foreach ($result['create'] as $koheraAddress) 
        {
            $this->dispatchSync(new CreateAddress($koheraAddress));
        }

        foreach ($result['delete'] as $koheraAddress) 
        {
            $this->dispatchSync(new SoftDeleteAddress($koheraAddress));
        }
    }
}
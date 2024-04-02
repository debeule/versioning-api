<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use App\School\Queries\AllAddresses;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalAddresses;
use Illuminate\Support\Collection;

final class AddressDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllAddresses $allAddressesQuery = new AllAddresses,
        private ExternalAddresses $externalAddressesQuery,
    ) {
        $this->allAddresses = $this->allAddressesQuery->get();
        $this->externalAddresses = $this->externalAddressesQuery->get();
    }

    public function externalAddresses(ExternalAddresses $externalAddressesQuery): self
    {
        return new self($this->allAddressesQuery, $externalAddressesQuery);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allAddresses, $this->externalAddresses));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allAddresses, $this->externalAddresses));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allAddresses, $this->externalAddresses));
    }
}

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
        private AllAddresses $allAddresses = new AllAddresses,
        private ExternalAddresses $externalAddresses,
    ) {}

    public function externalAddresses(ExternalAddresses $externalAddresses): self
    {
        return new self($this->allAddresses, $externalAddresses);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allAddresses->get(), $this->externalAddresses->get()));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allAddresses->get(), $this->externalAddresses->get()));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allAddresses->get(), $this->externalAddresses->get()));
    }
}

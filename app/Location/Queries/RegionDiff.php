<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use App\Location\Queries\AllRegions;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Imports\Queries\ExternalRegions;
use Illuminate\Support\Collection;

final class RegionDiff
{
    use DispatchesJobs;

    public function __construct(
        private AllRegions $allRegions = new AllRegions,
        private ExternalRegions $externalRegions,
    ) {}

    public function externalRegions(ExternalRegions $externalRegions): self
    {
        return new self($this->allRegions, $externalRegions);
    }

    public function additions(): Collection
    {
        return $this->DispatchSync(new FilterAdditions($this->allRegions->get(), $this->externalRegions->get()));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allRegions->get(), $this->externalRegions->get()));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allRegions->get(), $this->externalRegions->get()));
    }
}

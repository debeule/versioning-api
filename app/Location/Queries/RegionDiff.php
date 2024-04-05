<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Imports\Queries\ExternalRegions;
use App\Services\FilterAdditions;
use App\Services\FilterDeletions;
use App\Services\FilterUpdates;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class RegionDiff
{
    use DispatchesJobs;

    private Collection $allRegions;
    private Collection $externalRegions;

    public function __construct(
        private AllRegions $allRegionsQuery = new AllRegions,
        private ?ExternalRegions $externalRegionsQuery = null,
    ) {
        $this->allRegions = $this->allRegionsQuery->get();
        $this->externalRegions = $this->externalRegionsQuery->get();
    }

    public function externalRegions(ExternalRegions $externalRegionsQuery): self
    {
        return new self($this->allRegionsQuery, $externalRegionsQuery);
    }

    public function additions(): Collection
    {
        # TODO: filter services should be in the domain
        return $this->DispatchSync(new FilterAdditions($this->allRegions, $this->externalRegions));
    }

    public function deletions(): Collection
    {
        return $this->DispatchSync(new FilterDeletions($this->allRegions, $this->externalRegions));
    }

    public function updates(): Collection
    {
        return $this->DispatchSync(new FilterUpdates($this->allRegions, $this->externalRegions));
    }
}

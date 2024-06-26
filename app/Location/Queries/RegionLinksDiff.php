<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Imports\Queries\ExternalRegions;
use App\Location\Municipality;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

final class RegionLinksDiff
{
    use DispatchesJobs;

    private Collection $allRegions;
    private Collection $externalRegions;

    public function __construct(
        private AllRegions $allRegionsQuery = new AllRegions,
        private ?ExternalRegions $externalRegionsQuery = null,
    ) {
        $this->allRegions = $this->allRegionsQuery->get();
        $this->externalRegions = $this->externalRegionsQuery->getWithDoubles();
    }

    public function externalRegions(ExternalRegions $externalRegionsQuery): self
    {
        return new self($this->allRegionsQuery, $externalRegionsQuery);
    }

    public function toLink(): Collection
    {
        $regionsToLink = collect();

        foreach ($this->externalRegions as $externalRegion) 
        {
            $municipality = Municipality::where('postal_code', $externalRegion->postalCode())->first();

            if ($municipality->region_id == $externalRegion->recordId()) continue;
            if (! $this->allRegions->contains('record_id', $externalRegion->recordId())) continue;

            $regionsToLink->push($externalRegion);
        }

        return $regionsToLink;
    }
}

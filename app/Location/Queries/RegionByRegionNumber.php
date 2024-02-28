<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Region;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Values\Version;
use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Extensions\Eloquent\Scopes\HasRegionNumber;

final class RegionByRegionNumber
{
    public function __construct(
        public HasRegionNumber $hasRegionNumber = new HasRegionNumber(''),
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return Region::query()
            ->tap($this->hasRegionNumber)
            ->when($this->fromVersion, $this->fromVersion);
    }

    public function fromVersion(?string $versionString): self
    {
        return new self(
            $this->hasRegionNumber,
            new FromVersion(Version::fromString($versionString)),
        );
    }

    public function hasRegionNumber(string $regionNumber): self
    {
        return new self(
            new HasRegionNumber($regionNumber),
            $this->fromVersion,
        );
    }

    public function get(): Region
    {
        return $this->query()->firstOrFail();
    }

    public function find(): ?Region
    {
        try 
        {
            return $this->get();
        } 
        catch (ModelNotFoundException) 
        {
            return null;
        }
    }
}
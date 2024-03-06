<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Extensions\Eloquent\Scopes\HasPostalCode;
use App\Imports\Values\Version;
use App\Location\Municipality;
use App\Location\Region;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class RegionByPostalCode
{
    public function __construct(
        public HasPostalCode $hasPostalCode = new HasPostalCode(''),
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return Municipality::query()
            ->tap($this->hasPostalCode)
            ->when($this->fromVersion, $this->fromVersion);
    }

    public function fromVersion(?string $versionString): self
    {
        return new self(
            $this->hasPostalCode,
            new FromVersion(Version::fromString($versionString)),
        );
    }

    public function hasPostalCode(string $postalCode): self
    {
        return new self(
            new HasPostalCode($postalCode),
            $this->fromVersion,
        );
    }

    public function get(): ?Region
    {
        return $this->query()->firstOrFail()->region;
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
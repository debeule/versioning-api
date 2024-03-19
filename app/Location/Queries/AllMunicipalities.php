<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Imports\Values\Version;
use App\Location\Municipality;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class AllMunicipalities
{
    public function __construct(
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return Municipality::query()
            ->when($this->fromVersion, $this->fromVersion);
    }

    public function fromVersion(?string $versionString): self
    {
        return new self(
            new FromVersion(Version::fromString($versionString)),
        );
    }

    public function get(): Collection
    {
        return $this->query()->get();
    }

    public function find(): ?Collection
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
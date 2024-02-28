<?php

declare(strict_types=1);

namespace App\School\Queries;

use Illuminate\Database\Eloquent\Builder;
use App\School\School;
use App\Imports\Values\Version;

final class AllSchools
{
    public function __construct(
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return School::query()
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

    public function find(): ?School
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
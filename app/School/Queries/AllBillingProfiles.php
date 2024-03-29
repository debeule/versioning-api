<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Imports\Values\Version;
use App\School\BillingProfile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

final class AllBillingProfiles
{
    public function __construct(
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return BillingProfile::query()
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
<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Extensions\Eloquent\Scopes\HasName;
use App\Imports\Values\Version;
use App\School\School;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class SchoolByName
{
    public function __construct(
        public HasName $hasName = new HasName(''),
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return School::query()
            ->tap($this->hasName)
            ->when($this->fromVersion, $this->fromVersion);
    }

    public function fromVersion(?string $versionString): self
    {
        return new self(
            $this->hasName,
            new FromVersion(Version::fromString($versionString)),
        );
    }

    public function hasName(string $name): self
    {
        return new self(
            new HasName($name),
            $this->fromVersion,
        );
    }

    public function get(): School
    {
        /** @var School */
        return $this->query()->firstOrFail();
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
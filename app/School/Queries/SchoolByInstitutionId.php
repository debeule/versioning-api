<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\School\School;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Values\Version;
use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Extensions\Eloquent\Scopes\HasInstitutionId;
use Illuminate\Database\Eloquent\ModelNotFoundException;


final class SchoolByInstitutionId
{
    public function __construct(
        public HasInstitutionId $hasInstitutionId = new HasInstitutionId(''),
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return School::query()
            ->tap($this->hasInstitutionId)
            ->when($this->fromVersion, $this->fromVersion);
    }

    public function fromVersion(?string $versionString): self
    {
        return new self(
            $this->hasInstitutionId,
            new FromVersion(Version::fromString($versionString)),
        );
    }

    public function hasInstitutionId(string $institutionId): self
    {
        return new self(
            new HasInstitutionId($institutionId),
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
<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Extensions\Eloquent\Scopes\FromVersion;
use App\Extensions\Eloquent\Scopes\HasName;
use App\Sport\Sport;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Values\Version;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class SportByName
{
    public function __construct(
        public HasName $hasName = new HasName(''),
        public FromVersion $fromVersion = new FromVersion,
    ) {}

    public function query(): Builder
    {
        return Sport::query()
            ->tap($this->hasName)
            ->when($this->fromVersion, $this->fromVersion);
    }

    public function fromVersion(?string $versionString): self
    {
        return new self(
            $this->hasName,
            new FromVersion(new Version($versionString)),
        );
    }

    public function hasName(string $name): self
    {
        return new self(
            new HasName($name),
            $this->fromVersion,
        );
    }

    public function get(): Sport
    {
        return $this->query()->firstOrFail();
    }

    public function find(): ?Sport
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
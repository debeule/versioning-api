<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Sport\Sport;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\Values\Version;

final class SportByName
{
    public function __construct(
        public Version $version = new Version()
    ) {}

    public function query(string $name): Builder
    {
        $sportQuery = Sport::query()->where('name', '=', $name);

        return $this->version->versionQuery($sportQuery);
    }

    public function find(string $name): ?Sport
    {
        return $this->query($name)->first();
    }
}
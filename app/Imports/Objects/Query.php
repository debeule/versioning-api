<?php

declare(strict_types=1);

namespace App\Imports\Objects;

use Illuminate\Database\Query\Builder;
use App\Objects\Version;

final readonly class Query
{
    private Builder $query;

    public function __construct()
    {
        $this->query = $query;
    }

    public function __invoke(string $domain, string $searchField, string $searchInput, Version $version)
    {
        $this->buildQuery($this->query);
    }

    public function buildQuery(): Builder
    {
        return $domain::$this->query;
    }
    
    public function addFieldQuery(): Builder
    {
        return $query
            ->where('updated_at', '>=', (string)$this)
            ->orderBy('version', 'asc')
            ->first();
    }

    public function addVersionQuery(): Builder
    {
        $this->$query->mergeBindings($this->version->versionQuery());
    }

    public function __toString(): string
    {
        return $this->version->format('Y-m-d');
    }
}
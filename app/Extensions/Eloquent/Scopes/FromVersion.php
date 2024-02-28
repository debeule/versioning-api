<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Imports\Values\Version;
use Illuminate\Database\Eloquent\Builder;

final readonly class FromVersion
{
    public function __construct(
        private Version $version = new Version,
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query
            ->whereDate('created_at', '<=', (string) $this->version)
            ->where(function ($query) {
                $query->WhereNull('deleted_at')
                    ->orWhereDate('deleted_at', '>', (string) $this->version);
            });
    }
}
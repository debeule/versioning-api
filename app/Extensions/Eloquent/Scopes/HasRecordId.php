<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use Illuminate\Database\Eloquent\Builder;

final class HasRecordId
{
    public function __construct(
        private string $value = '',
    ) {}

    public function __invoke(Builder $query): Builder
    {
        return $query->where('record_id', '=', $this->value);
    }
}
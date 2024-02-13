<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Sport\Sport;
use Illuminate\Database\Eloquent\ModelNotFoundException;

final class SportByName
{
    public function __construct(
        private ?FromVersion $fromVersion = null,
    ) {}

    public function query(string $name): Builder
    {
        return Sport::query()
            ->where('name', '=', $name)
            ->when($this->fromVersion, $this->fromVersion)
            ->orderBy('created_at', 'desc');
    }

    public function get(string $name): Sport
    {
        return $this->query($name)->firstOrFail();
    }

    public function find(string $name): ?Sport
    {
        return $this->query($name)->first();
    }
}
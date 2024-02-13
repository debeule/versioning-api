<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Sport\Sport;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Imports\Version;

final class SportByName
{
    public function __invoke(string $name): ?Sport
    {
        $version = new Version(20240101);

        return Sport::where('name', $name)
        ->where('updated_at', '>=', (string)$version)
        ->first();
    }
}
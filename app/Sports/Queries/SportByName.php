<?php

declare(strict_types=1);

namespace App\Sports\Queries;

use App\Sports\Sport;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Objects\Version;

final class SportByName
{
    public function __invoke(string $name): ?Sport
    {
        $version = new Version('2024', '01', '01');

        return Sport::where('name', $name)
        ->where('updated_at', '>=', (string)$version)
        ->first();
    }
}
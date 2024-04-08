<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\Sport\Sport as DbSport;

interface Sport
{
    public function recordId(): int;
    public function name(): string;

    public function hasChanged(DbSport $dbSport): bool;
}
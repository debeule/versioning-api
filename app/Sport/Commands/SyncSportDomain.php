<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Kohera\Commands\SyncSportsTable;

final class SyncSportDomain
{
    public function __invoke(): void
    {
        $syncSportsTable = new SyncSportsTable();
        $syncSportsTable();
    }
}

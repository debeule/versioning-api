<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Kohera\Commands\SyncSports;

final class SyncSportDomain
{
    public function __invoke(): void
    {
        $syncSportsTable = new SyncSports();
        $syncSportsTable();
    }
}

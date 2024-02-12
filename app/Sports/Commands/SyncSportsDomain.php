<?php

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Kohera\Commands\SyncSportsTable;

final class SyncSportsDomain
{
    public function __invoke(): void
    {
        $syncSportsTable = new SyncSportsTable();
        $syncSportsTable();
    }
}

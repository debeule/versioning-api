<?php

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Kohera\Commands\SyncSportsTableCommand;

class SyncSportsDomainCommand
{
    public function __invoke(): void
    {
        $syncSportsTableCommand = new SyncSportsTableCommand();
        $syncSportsTableCommand();
    }
}

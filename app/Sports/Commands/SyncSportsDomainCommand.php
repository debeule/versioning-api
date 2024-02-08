<?php

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Kohera\Commands\SyncSportsTableCommand;

class SyncSchoolsDomainJob implements ShouldQueue
{
    public function __invoke(): void
    {
        $syncSportsTableCommand = new SyncSportsTableCommand();
        $syncSportsTableCommand();
    }
}

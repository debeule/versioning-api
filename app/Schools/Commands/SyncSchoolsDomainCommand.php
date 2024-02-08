<?php

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Kohera\Commands\SyncSchoolsTableCommand;
use App\Kohera\Commands\SyncRegionsTableCommand;

class SyncSchoolsDomainCommand
{
    public function __invoke(): void
    {
        $syncRegionsTableCommand = new SyncRegionsTableCommand();
        $syncRegionsTableCommand();

        $syncSchoolsTableCommand = new SyncSchoolsTableCommand();
        $syncSchoolsTableCommand();
    }
}

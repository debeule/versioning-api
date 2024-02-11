<?php

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Kohera\Commands\SyncRegionsTableCommand;
use App\Kohera\Commands\SyncSchoolsTableCommand;

final class SyncSchoolsDomainCommand
{
    public function __invoke(): void
    {
        $syncRegionsTableCommand = new SyncRegionsTableCommand();
        $syncRegionsTableCommand();

        $syncSchoolsTableCommand = new SyncSchoolsTableCommand();
        $syncSchoolsTableCommand();
    }
}
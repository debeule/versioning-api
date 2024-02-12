<?php

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Kohera\Commands\SyncRegionsTable;
use App\Kohera\Commands\SyncSchoolsTable;

final class SyncSchoolsDomain
{
    public function __invoke(): void
    {
        $syncRegionsTable = new SyncRegionsTable();
        $syncRegionsTable();

        $syncSchoolsTable = new SyncSchoolsTable();
        $syncSchoolsTable();
    }
}
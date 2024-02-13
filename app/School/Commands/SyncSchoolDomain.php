<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Commands\SyncRegionsTable;
use App\Kohera\Commands\SyncSchoolsTable;

final class SyncSchoolDomain
{
    public function __invoke(): void
    {
        $syncRegionsTable = new SyncRegionsTable();
        $syncRegionsTable();

        $syncSchoolsTable = new SyncSchoolsTable();
        $syncSchoolsTable();
    }
}
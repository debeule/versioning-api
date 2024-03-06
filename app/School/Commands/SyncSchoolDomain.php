<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Commands\SyncAddresses;
use App\Kohera\Commands\SyncBillingProfiles;
use App\Kohera\Commands\SyncSchools;

final class SyncSchoolDomain
{
    public function __invoke(): void
    {
        $syncaddresses = new SyncAddresses();
        $syncaddresses();
        
        $syncSchools = new SyncSchools();
        $syncSchools();

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
    }
}
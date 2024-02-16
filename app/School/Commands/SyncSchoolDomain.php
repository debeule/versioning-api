<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Commands\SyncRegions;
use App\Kohera\Commands\SyncSchools;
use App\Bpost\Commands\SyncMunicipalities;
use App\Kohera\Commands\SyncAddresses;
use App\Kohera\Commands\SyncBillingProfiles;

final class SyncSchoolDomain
{
    public function __invoke(): void
    {
        $syncMunicipalities = new SyncMunicipalities();
        $syncMunicipalities();

        $syncRegions = new SyncRegions();
        $syncRegions();

        $syncaddresses = new SyncAddresses();
        $syncaddresses();
        
        $syncSchools = new SyncSchools();
        $syncSchools();

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
    }
}
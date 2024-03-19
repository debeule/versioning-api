<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Bpost\Commands\SyncMunicipalities;
use App\Kohera\Commands\SyncAddresses;
use App\Kohera\Commands\SyncBillingProfiles;
use App\Kohera\Commands\SyncRegions;
use App\Kohera\Commands\SyncSchools;
use App\Kohera\Commands\SyncSports;
use App\Kohera\Commands\SyncRegionLinks;
use App\Location\Municipality;
use App\Location\Region;
use App\Kohera\Region as KoheraRegion;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;

final class TestHandler
{
    public function __invoke(): string
    {

        // $syncMunicipalities = new SyncMunicipalities();
        // $syncMunicipalities();

        $syncRegions = new SyncRegions;
        $syncRegions();

        $syncRegionLinks = new SyncRegionLinks();
        $syncRegionLinks();
        
        $syncaddresses = new SyncAddresses();
        $syncaddresses();

        $syncSchools = new SyncSchools();
        $syncSchools();

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $syncSports = new SyncSports;
        $syncSports();

        return 'done';
    }
}
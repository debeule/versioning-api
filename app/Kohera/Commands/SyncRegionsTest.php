<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Testing\TestCase;
use App\Location\Region;
use App\Kohera\Region as KoheraRegion;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use Database\Main\Factories\AddressFactory;
use App\Kohera\Commands\SyncRegions;

final class SyncRegionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $regionRecords = KoheraRegionFactory::new()->count(3)->create();

        $syncRegions = new SyncRegions();
        $syncRegions();
    }

    /**
     * @test
     */
    public function itDispatchesCreateRegionsWhenNotExists(): void
    {
        $regionRecords = KoheraRegionFactory::new()->count(3)->create();

        $existingRegions = Region::get();
        $koheraRegions = KoheraRegion::get();

        $this->assertGreaterThan($existingRegions->count(), $koheraRegions->count());

        $syncRegions = new SyncRegions();
        $syncRegions();

        $existingRegions = Region::get();
        $koheraRegions = KoheraRegion::get();
        $this->assertEquals($existingRegions->count(), $koheraRegions->count());
    }

    /**
     * @test
     */
    public function itSoftDeletesDeletedRecords(): void
    {
        $koheraRegion = KoheraRegion::first();
        $koheraRegionName = $koheraRegion->name();
        $koheraRegion->delete();

        
        $syncRegions = new SyncRegions();
        $syncRegions();
            
        $this->assertSoftDeleted(Region::withTrashed()->where('name', $koheraRegionName)->first());

        $existingRegions = Region::withTrashed()->get();
        $koheraRegions = KoheraRegion::get();

        $this->assertGreaterThan($koheraRegions->count(), $existingRegions->count());
    }
}
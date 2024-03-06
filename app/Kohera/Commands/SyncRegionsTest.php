<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Region as KoheraRegion;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncRegionsTest extends TestCase
{
    #[Test]
    public function itDispatchesCreateRegionsWhenNotExists(): void
    {
        $regionRecords = KoheraRegionFactory::new()->count(3)->create();

        $syncRegions = new SyncRegions();
        $syncRegions();

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

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        $regionRecords = KoheraRegionFactory::new()->count(3)->create();

        $syncRegions = new SyncRegions();
        $syncRegions();
        
        $koheraRegion = KoheraRegion::first();
        $koheraRegionName = $koheraRegion->name();
        $koheraRegion->delete();

        
        $syncRegions = new SyncRegions();
        $syncRegions();
            
        $this->assertSoftDeleted(Region::where('name', $koheraRegionName)->first());

        $existingRegions = Region::get();
        $koheraRegions = KoheraRegion::get();

        $this->assertGreaterThan($koheraRegions->count(), $existingRegions->count());
    }
}
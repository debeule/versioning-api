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

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        
        $this->dispatchSync(new CreateRegion($koheraRegion));

        $oldRegionRecord = Region::where('region_number', $koheraRegion->regionNumber())->first();

        $koheraRegion->RegionNaam = 'new name';
        $this->dispatchSync(new CreateRegion($koheraRegion));

        $updatedRegionRecord = Region::where('name', $koheraRegion->name())->first();

        $this->assertTrue($oldRegionRecord->name !== $updatedRegionRecord->name);
        $this->assertSoftDeleted($oldRegionRecord);

        $this->assertEquals($updatedRegionRecord->name, $koheraRegion->name());
        $this->assertEquals($oldRegionRecord->record_id, $updatedRegionRecord->record_id);
    }
}
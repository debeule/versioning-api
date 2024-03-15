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
    public function itCreatesRegionRecordsWhenNotExists(): void
    {
        KoheraRegionFactory::new()->create();

        $syncRegions = new SyncRegions();
        $syncRegions();

        $this->assertEquals(Region::count(), KoheraRegion::count());
    }

    #[Test]
    public function itSoftDeletesRegionRecordsWhenDeleted(): void
    {
        $koheraRegions = KoheraRegionFactory::new()->count(2)->create();

        $syncRegions = new SyncRegions();
        $syncRegions();
        
        $koheraRegionRecordId = $koheraRegions->first()->recordId();
        $koheraRegions->first()->delete();
        
        $syncRegions = new SyncRegions();
        $syncRegions();

        $this->assertSoftDeleted(Region::where('record_id', $koheraRegionRecordId)->first());
        $this->assertGreaterThan(KoheraRegion::count(), Region::count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        
        $syncRegions = new SyncRegions();
        $syncRegions();

        $oldRegion = Region::where('name', $koheraRegion->name())->first();

        $koheraRegion->RegionNaam = 'new name';
        $koheraRegion->save();
        
        $syncRegions = new SyncRegions();
        $syncRegions();

        $updatedRegion = Region::where('name', $koheraRegion->name())->first();

        $this->assertTrue($oldRegion->name !== $updatedRegion->name);
        $this->assertSoftDeleted($oldRegion);

        $this->assertEquals($updatedRegion->name, $koheraRegion->name());
        $this->assertEquals($oldRegion->record_id, $updatedRegion->record_id);
    }
}
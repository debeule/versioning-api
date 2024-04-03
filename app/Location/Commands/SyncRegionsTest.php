<?php

declare(strict_types=1);

namespace App\Location\Commands;

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

        $this->dispatchSync(new SyncRegions);

        $this->assertEquals(Region::count(), KoheraRegion::count());
    }

    #[Test]
    public function itSoftDeletesRegionRecordsWhenDeleted(): void
    {
        $koheraRegions = KoheraRegionFactory::new()->count(2)->create();

        $this->dispatchSync(new SyncRegions);
        
        $koheraRegionRecordId = $koheraRegions->first()->recordId();
        $koheraRegions->first()->delete();
        
        $this->dispatchSync(new SyncRegions);

        $this->assertSoftDeleted(Region::where('record_id', $koheraRegionRecordId)->first());
        $this->assertGreaterThan(KoheraRegion::count(), Region::count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        
        $this->dispatchSync(new SyncRegions);

        $oldRegion = Region::where('name', $koheraRegion->name())->first();

        $koheraRegion->RegionNaam = 'new name';
        $koheraRegion->save();
        
        $this->dispatchSync(new SyncRegions);

        $updatedRegion = Region::where('name', $koheraRegion->name())->first();

        $this->assertTrue($oldRegion->name !== $updatedRegion->name);
        $this->assertSoftDeleted($oldRegion);

        $this->assertEquals($updatedRegion->name, $koheraRegion->name());
        $this->assertEquals($oldRegion->record_id, $updatedRegion->record_id);
    }
}
<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Kohera\Region as KoheraRegion;
use App\Location\Commands\CreateRegion;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use PHPUnit\Framework\Attributes\Test;

final class RegionDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectAdditions(): void
    {
        $koheraRegions = KoheraRegionFactory::new()->count(3)->create();

        $this->dispatchSync(new CreateRegion($koheraRegions->first()));

        $regionDiff = app(RegionDiff::class);

        $result = $regionDiff->additions();

        $this->assertInstanceOf(KoheraRegion::class, $result->first());
        $this->assertEquals(2, $result->count());
    }
    
    #[Test]
    public function itReturnsCorrectDeletions(): void
    {
        $koheraRegions = KoheraRegionFactory::new()->count(3)->create();
        $removedKoheraRegion = $koheraRegions->first();

        $removedKoheraRegion->delete();

        $this->dispatchSync(new CreateRegion($removedKoheraRegion));

        $regionDiff = app(RegionDiff::class);

        $result = $regionDiff->deletions();

        $this->assertInstanceOf(Region::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('name', $removedKoheraRegion->name())->isNotEmpty());
    }
    
    #[Test]
    public function itReturnsCorrectUpdates(): void
    {
        $koheraRegions = KoheraRegionFactory::new()->count(3)->create();

        $this->dispatchSync(new CreateRegion($koheraRegions->first()));

        $newName = "new region name";
        $koheraRegions->first()->RegionNaam = $newName;
        $koheraRegions->first()->save();

        $regionDiff = app(RegionDiff::class);

        $result = $regionDiff->updates();

        $this->assertInstanceOf(KoheraRegion::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertEquals($newName, $result->first()->RegionNaam);
    }
}
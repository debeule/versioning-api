<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Region;
use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;


final class AllRegionsTest extends TestCase
{
    #[Test]
    public function ItCanGetAllRegions(): void
    {
        RegionFactory::new()->count(3)->create();

        $allRegions = new AllRegions;
        $result = $allRegions->find();

        $allRegionRecords = Region::get();

        $this->assertEquals($allRegionRecords->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfRegions(): void
    {
        RegionFactory::new()->count(3)->create();

        $allRegions = new AllRegions;
        $result = $allRegions->find();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Region::class, $result->first());
    }
}
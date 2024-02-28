<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Collection;
use App\Location\Queries\AllRegions;
use App\Location\Region;
use Database\Main\Factories\RegionFactory;


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
    public function ItReturnsCollectionOfRegions()
    {
        $region = RegionFactory::new()->count(3)->create();

        $allRegions = new AllRegions;
        $result = $allRegions->find();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Region::class, $result->first());
    }
}
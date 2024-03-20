<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Main\Factories\RegionFactory;
use App\Location\Region;

final class RegionByRegionNumberTest extends TestCase
{
    #[Test]
    public function ItCanGetARegionByRegionNumber(): void
    {
        $region = RegionFactory::new()->create();

        $regionByRegionNumber = new RegionByRegionNumber;
        $result = $regionByRegionNumber->hasRegionNumber((string) $region->region_number)->find();

        $region = Region::where('region_number', $region->region_number)->first();
        
        $this->assertEquals($region->count(), $result->count());
    }

    #[Test]
    public function ItReturnsNullIfRegionNumberNotExists(): void
    {
        $regionByRegionNumber = new RegionByRegionNumber;
        $result = $regionByRegionNumber->hasRegionNumber('NonExistentRegionNumber123')->find();

        $this->assertNull($result);
    }

    #[Test]
    public function ItReturnsRegion(): void
    {
        $region = RegionFactory::new()->create();

        $regionByRegionNumber = new RegionByRegionNumber;
        $result = $regionByRegionNumber->hasRegionNumber((string) $region->region_number)->find();

        $this->assertInstanceOf(Region::class, $result);
    }
}
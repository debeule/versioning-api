<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Region;
use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use PHPUnit\Framework\Attributes\Test;

final class RegionByNameTest extends TestCase
{
    #[Test]
    public function ItCanGetARegionByName(): void
    {
        $region = RegionFactory::new()->create();

        $regionByName = new RegionByName;
        $result = $regionByName->hasName($region->name)->find();

        $region = Region::where('name', $region->name)->first();
        
        $this->assertEquals($region->count(), $result->count());
    }

    #[Test]
    public function ItReturnsNullIfRegionNameNotExists(): void
    {
        $regionByName = new RegionByName;
        $result = $regionByName->hasName('NonExistentRegion')->find();

        $this->assertNull($result);
    }

    #[Test]
    public function ItReturnsRegion(): void
    {
        $region = RegionFactory::new()->create();

        $regionByName = new RegionByName;
        $result = $regionByName->hasName($region->name)->find();

        $this->assertInstanceOf(Region::class, $result);
    }
}
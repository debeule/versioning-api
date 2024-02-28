<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Location\Queries\RegionByName;
use App\Location\Region;
use App\Location\Municipality;
use Database\Main\Factories\RegionFactory;
use Database\Main\Factories\MunicipalityFactory;
use Illuminate\Database\Eloquent\Collection;

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
    public function ItReturnsNullIfRegionNameNotExists()
    {
        $regionByName = new RegionByName;
        $result = $regionByName->hasName('NonExistentRegion')->find();

        $this->assertNull($result);
    }

    #[Test]
    public function ItReturnsRegion()
    {
        $region = RegionFactory::new()->create();

        $regionByName = new RegionByName;
        $result = $regionByName->hasName($region->name)->find();

        $this->assertInstanceOf(Region::class, $result);
    }
}
<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Location\Queries\RegionByPostalCode;
use App\Location\Region;
use App\Location\Municipality;
use Database\Main\Factories\RegionFactory;
use Database\Main\Factories\MunicipalityFactory;
use Illuminate\Database\Eloquent\Collection;

final class RegionByPostalCodeTest extends TestCase
{
    #[Test]
    public function ItCanGetARegionByPostalCode(): void
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $regionByPostalCode = new RegionByPostalCode;
        $result = $regionByPostalCode->hasPostalCode($municipality->postal_code)->find();

        $municipality = Municipality::where('postal_code', $municipality->postal_code)->first();
        $region = Region::where('id', $municipality->region_id)->first();
        
        $this->assertEquals($region->count(), $result->count());
    }

    #[Test]
    public function ItReturnsNullIfPostalCodeNotLinked()
    {
        $municipality = MunicipalityFactory::new()->create();

        $regionByPostalCode = new RegionByPostalCode;
        $result = $regionByPostalCode->hasPostalCode($municipality->postal_code)->find();

        $this->assertNull($result);
    }

    #[Test]
    public function ItReturnsRegion()
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $regionByPostalCode = new RegionByPostalCode;
        $result = $regionByPostalCode->hasPostalCode($municipality->postal_code)->find();

        $this->assertInstanceOf(Region::class, $result);
    }
}
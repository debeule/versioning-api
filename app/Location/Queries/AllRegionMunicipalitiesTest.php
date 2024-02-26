<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Collection;
use App\Location\Queries\AllRegionMunicipalities;
use App\Location\Region;
use App\Location\Municipality;
use Database\Main\Factories\RegionFactory;
use Database\Main\Factories\MunicipalityFactory;

final class AllRegionMunicipalitiesTest extends TestCase
{
    #[Test]
    public function ItCanGetAllRegionMunicipalities(): void
    {
        $region = RegionFactory::new()->create();
        
        MunicipalityFactory::new()->count(3)->withRegionId($region->id)->create();

        $allRegionMunicipalities = new AllRegionMunicipalities;
        $result = $allRegionMunicipalities->get($region->region_number);

        $allRegionMunicipalities = Municipality::where('region_id', $region->id)->get();
        
        $this->assertEquals($allRegionMunicipalities->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfMunicipalities()
    {
        $region = RegionFactory::new()->create();
        MunicipalityFactory::new()->count(3)->withRegionId($region->id)->create();

        $allRegionMunicipalities = new AllRegionMunicipalities;
        $result = $allRegionMunicipalities->get($region->region_number);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Municipality::class, $result->first());
    }
}
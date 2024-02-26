<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Collection;
use App\Location\Queries\AllLinkedMunicipalities;
use App\Location\Region;
use App\Location\Municipality;
use Database\Main\Factories\RegionFactory;
use Database\Main\Factories\MunicipalityFactory;

final class AllLinkedMunicipalitiesTest extends TestCase
{
    #[Test]
    public function ItCanGetAllLinkedMunicipalities(): void
    {
        $region = RegionFactory::new()->create();
        
        MunicipalityFactory::new()->count(3)->withRegionId($region->id)->create();

        $allLinkedMunicipalities = new AllLinkedMunicipalities;
        $result = $allLinkedMunicipalities->get($region->region_number);

        $allLinkedMunicipalities = Municipality::where('region_id', $region->id)->get();
        
        $this->assertEquals($allLinkedMunicipalities->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfMunicipalities()
    {
        $region = RegionFactory::new()->create();
        MunicipalityFactory::new()->count(3)->withRegionId($region->id)->create();

        $allLinkedMunicipalities = new AllLinkedMunicipalities;
        $result = $allLinkedMunicipalities->get($region->region_number);

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Municipality::class, $result->first());
    }
}
<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use Database\Main\Factories\MunicipalityFactory;
use App\Location\Commands\LinkRegion;
use App\Location\Commands\CreateRegion;
use App\Kohera\Region as KoheraRegion;
use App\Location\Municipality;
use App\Location\Region;

final class LinkRegionTest extends TestCase
{
    #[Test]
    public function itReturnsFalseWhenRegionDoesNotExist(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();

        MunicipalityFactory::new()->withPostalCode($koheraRegion->postalCode())->create();

        $this->assertFalse($this->dispatchSync(new LinkRegion($koheraRegion)));
    }

    #[Test]
    public function itReturnsFalseWhenMunicipalityDoesNotExist(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        
        $this->dispatchSync(new CreateRegion($koheraRegion));

        $this->assertFalse($this->dispatchSync(new LinkRegion($koheraRegion)));
    }

    #[Test]
    public function itLinksMunicipalityToRegionWhenExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        
        MunicipalityFactory::new()->withPostalCode($koheraRegion->postalCode())->count(3)->create();

        $this->dispatchSync(new CreateRegion($koheraRegion));

        $region = Region::where('region_id', $koheraRegion->regionId())->first();

        $result = $this->dispatchSync(new LinkRegion($koheraRegion));

        $linkedMunicipalities = Municipality::where('region_id', $region->id)->get();

        $this->assertTrue($result); 
        $this->assertEquals(3, $linkedMunicipalities->count());
    }
}
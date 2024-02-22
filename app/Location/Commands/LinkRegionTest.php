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
    private KoheraRegion $koheraRegion;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraRegion = KoheraRegionFactory::new()->create();
    } 

    #[Test]
    public function itReturnsFalseWhenRegionDoesNotExist(): void
    {
        MunicipalityFactory::new()->withPostalCode($this->koheraRegion->postalCode())->create();

        $this->assertFalse($this->dispatchSync(new LinkRegion($this->koheraRegion)));
    }

    #[Test]
    public function itReturnsFalseWhenMunicipalityDoesNotExist(): void
    {
        $this->dispatchSync(new CreateRegion($this->koheraRegion));

        $this->assertFalse($this->dispatchSync(new LinkRegion($this->koheraRegion)));
    }

    #[Test]
    public function itLinksMunicipalityToRegionWhenExists(): void
    {
        MunicipalityFactory::new()->withPostalCode($this->koheraRegion->postalCode())->count(3)->create();

        $this->dispatchSync(new CreateRegion($this->koheraRegion));

        $region = Region::where('region_id', $this->koheraRegion->regionId())->first();

        $result = $this->dispatchSync(new LinkRegion($this->koheraRegion));

        $linkedMunicipalities = Municipality::where('region_id', $region->id)->get();

        $this->assertTrue($result); 
        $this->assertEquals(3, $linkedMunicipalities->count());
    }
}
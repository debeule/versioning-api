<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Location\Municipality;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use Database\Main\Factories\MunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;

final class LinkRegionTest extends TestCase
{
    #[Test]
    public function itLinksMunicipalitiesToRegionWhenExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        $this->dispatchSync(new CreateRegion($koheraRegion));
        
        MunicipalityFactory::new()->withPostalCode($koheraRegion->postalCode())->count(3)->create();

        $region = Region::where('record_id', $koheraRegion->recordId())->first();

        $result = $this->dispatchSync(new LinkRegion($region));

        $linkedMunicipalities = Municipality::where('region_id', $region->id)->get();

        $this->assertTrue($result); 

        $this->assertEquals(1, $linkedMunicipalities->count());
    }
}
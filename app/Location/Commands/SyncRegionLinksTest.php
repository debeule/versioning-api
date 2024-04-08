<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Main\Factories\MunicipalityFactory;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use App\Location\Region;
use App\Kohera\Region as KoheraRegion;
use App\Location\Municipality;

final class SyncRegionLinksTest extends TestCase
{
    #[Test]
    public function itLinksRegionWhenNotLinked2(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        MunicipalityFactory::new()->withPostalCode($koheraRegion->postalCode())->create();

        $region = $this->dispatchSync(new CreateRegion($koheraRegion));

        $this->dispatchSync(new SyncRegionLinks);
        
        $result = Municipality::first();

        $this->assertEquals($result->region_id, Region::first()->id);
        $this->assertEquals(Region::count(), KoheraRegion::count());
    }
}
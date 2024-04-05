<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Location\Region;
use App\Kohera\Region as KoheraRegion;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use Database\Main\Factories\MunicipalityFactory;
use App\Location\Commands\CreateRegion;

final class RegionLinksDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectRegionsToLink(): void
    {
        $koheraRegions = KoheraRegionFactory::new()->count(3)->create();
        MunicipalityFactory::new()->withPostalCode($koheraRegions->first()->postalCode())->create();

        $this->dispatchSync(new CreateRegion($koheraRegions->first()));
        $this->dispatchSync(new CreateRegion($koheraRegions->last()));

        Region::first()->delete();

        $regionLinksDiff = app(RegionLinksDiff::class);

        $result = $regionLinksDiff->toLink();
        
        $this->assertInstanceOf(KoheraRegion::class, $result->first());
        $this->assertEquals(1, $result->count());
    }
}
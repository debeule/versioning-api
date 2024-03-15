<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Kohera\Region as KoheraRegion;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use PHPUnit\Framework\Attributes\Test;


final class CreateRegionTest extends TestCase
{
    #[Test]
    public function itCanCreateSportFromKoheraSport(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();

        $this->dispatchSync(new CreateRegion($koheraRegion));
        
        $region = Region::where('record_id', $koheraRegion->recordId())->first();
        
        $this->assertInstanceOf(KoheraRegion::class, $koheraRegion);
        $this->assertInstanceOf(Region::class, $region);
        
        $this->assertEquals($koheraRegion->regionNumber(), $region->region_number);
    }
}
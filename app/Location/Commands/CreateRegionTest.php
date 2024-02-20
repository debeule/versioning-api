<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Testing\TestCase;
use App\Sport\Sport;
use App\Kohera\Sport as KoheraSport;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use App\Testing\RefreshDatabase;
use App\Location\Commands\CreateRegion;
use App\Kohera\Region as KoheraRegion;
use App\Location\Region;


final class CreateRegionTest extends TestCase
{
    private KoheraRegion $koheraRegion;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraRegion = KoheraRegionFactory::new()->create();
    } 

    /**
     * @test
     */
    public function itCanCreateSportFromKoheraSport(): void
    {
        $this->dispatchSync(new CreateRegion($this->koheraRegion));
        
        $region = Region::where('region_id', $this->koheraRegion->regionId())->first();
        
        $this->assertInstanceOf(KoheraRegion::class, $this->koheraRegion);
        $this->assertInstanceOf(Region::class, $region);
        
        $this->assertEquals($this->koheraRegion->regionNumber(), $region->region_number);
    }

    /**
     * @test
     */
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $this->dispatchSync(new CreateRegion($this->koheraRegion));

        $this->assertFalse($this->dispatchSync(new CreateRegion($this->koheraRegion)));
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->dispatchSync(new CreateRegion($this->koheraRegion));

        $oldRegionRecord = Region::where('region_number', $this->koheraRegion->regionNumber())->first();

        $this->koheraRegion->RegionNaam = 'new name';
        $this->dispatchSync(new CreateRegion($this->koheraRegion));

        $updatedRegionRecord = Region::where('name', $this->koheraRegion->name())->first();

        $this->assertTrue($oldRegionRecord->name !== $updatedRegionRecord->name);
        $this->assertSoftDeleted($oldRegionRecord);

        $this->assertEquals($updatedRegionRecord->name, $this->koheraRegion->name());
        $this->assertEquals($oldRegionRecord->region_id, $updatedRegionRecord->region_id);
    }
}
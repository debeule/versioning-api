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

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();

        $this->dispatchSync(new CreateRegion($koheraRegion));

        $this->assertFalse($this->dispatchSync(new CreateRegion($koheraRegion)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraRegion = KoheraRegionFactory::new()->create();
        
        $this->dispatchSync(new CreateRegion($koheraRegion));

        $oldRegionRecord = Region::where('region_number', $koheraRegion->regionNumber())->first();

        $koheraRegion->RegionNaam = 'new name';
        $this->dispatchSync(new CreateRegion($koheraRegion));

        $updatedRegionRecord = Region::where('name', $koheraRegion->name())->first();

        $this->assertTrue($oldRegionRecord->name !== $updatedRegionRecord->name);
        $this->assertSoftDeleted($oldRegionRecord);

        $this->assertEquals($updatedRegionRecord->name, $koheraRegion->name());
        $this->assertEquals($oldRegionRecord->record_id, $updatedRegionRecord->record_id);
    }
}
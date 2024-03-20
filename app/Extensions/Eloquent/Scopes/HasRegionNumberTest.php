<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Main\Factories\RegionFactory;
use App\Location\Region;

final class HasRegionNumberTest extends TestCase
{
    #[Test]
    public function HasPostalCodeScopeQueryReturnsCorrectRecord(): void
    {
        $regions = RegionFactory::new()->count(2)->create();

        $hasRegionNumber = new HasRegionNumber((string) $regions->first()->region_number);

        $result = Region::query()->tap($hasRegionNumber)->first();

        $this->assertEquals($regions->first()->region_number, $result->region_number);
        $this->assertInstanceOf(Region::class, $result);
    }
}
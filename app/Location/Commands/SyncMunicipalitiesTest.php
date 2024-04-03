<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Kohera\Region as KoheraRegion;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncMunicipalitiesTest extends TestCase
{
    # TODO: Write tests
    #[Test]
    public function addTestsHere(): void
    {
        $this->assertEquals(true, false);
    }
}
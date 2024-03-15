<?php

declare(strict_types=1);

namespace App\Region\Commands;

use App\Kohera\Region as KoheraRegion;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\regionFactory as KoheraregionFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteRegionTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteRegion()
    {
        $Region = Region::factory()->create();

        $this->dispatchSync(new SoftDeleteregion($Region));
        dd(Region::get());
        $this->assertSoftDeleted($Region);
    }
}
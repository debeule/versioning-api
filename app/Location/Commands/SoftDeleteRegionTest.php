<?php

declare(strict_types=1);

namespace App\Region\Commands;

use App\Location\Region;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteRegionTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteRegion(): void
    {
        $Region = Region::factory()->create();

        $this->dispatchSync(new SoftDeleteregion($Region));
        
        $this->assertSoftDeleted($Region);
    }
}
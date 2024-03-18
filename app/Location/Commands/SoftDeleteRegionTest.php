<?php

declare(strict_types=1);

namespace App\Location\Commands;

use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteRegionTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteRegion(): void
    {
        $Region = RegionFactory::new()->create();

        $this->dispatchSync(new SoftDeleteregion($Region));
        
        $this->assertSoftDeleted($Region);
    }
}
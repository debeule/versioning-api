<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Municipality;
use App\Location\Region;
use App\Testing\TestCase;
use Database\Main\Factories\MunicipalityFactory;
use Database\Main\Factories\RegionFactory;
use PHPUnit\Framework\Attributes\Test;

final class RegionByRegionNumberTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $this->assertTrue(false);
    }
}
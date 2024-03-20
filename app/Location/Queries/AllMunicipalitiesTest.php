<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Region;
use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;


final class AllMunicipalitiesTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $this->assertTrue(false);
    }
}
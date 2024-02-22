<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Kohera\Region;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;

final class AllRegionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        KoheraRegionFactory::new()->count(3)->create();
        $this->allRegions = new AllRegions;
    }

    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        $this->assertInstanceOf(Builder::class, $this->allRegions->query());
    }

    #[Test]
    public function getReturnsCollectionOfRegions(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allRegions->get());
        $this->assertInstanceOf(Region::class, $this->allRegions->get()[0]);
    }
}
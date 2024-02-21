<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Kohera\Region;
use Database\Main\Factories\RegionFactory;

final class AllRegionsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->allRegions = new AllRegions;
    }

    /**
     * @test
     */
    public function queryReturnsBuilderInstance(): void
    {
        $this->assertInstanceOf(Builder::class, $this->allRegions->query());
    }

    /**
     * @test
     */
    public function getReturnsCollectionOfRegions(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allRegions->get());
        $this->assertInstanceOf(Region::class, $this->allRegions->get()[0]);
    }
}
<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\Region;
use App\Testing\TestCase;
use Database\Kohera\Factories\RegionFactory as KoheraRegionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;

final class AllRegionsTest extends TestCase
{

    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        KoheraRegionFactory::new()->count(3)->create();
        $this->allRegions = new AllRegions;

        $this->assertInstanceOf(Builder::class, $this->allRegions->query());
    }

    #[Test]
    public function getReturnsCollectionOfRegions(): void
    {
        KoheraRegionFactory::new()->count(3)->create();
        $this->allRegions = new AllRegions;
        
        $this->assertInstanceOf(Collection::class, $this->allRegions->get());
        $this->assertInstanceOf(Region::class, $this->allRegions->get()[0]);
    }
}
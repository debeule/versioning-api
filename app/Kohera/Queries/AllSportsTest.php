<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Kohera\Sport;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;

final class AllSportsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        KoheraSportFactory::new()->count(3)->create();
        $this->allSports = new AllSports;
    }

    /**
     * @test
     */
    public function queryReturnsBuilderInstance(): void
    {
        $this->assertInstanceOf(Builder::class, $this->allSports->query());
    }

    /**
     * @test
     */
    public function getReturnsCollectionOfSports(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allSports->get());
        $this->assertInstanceOf(Sport::class, $this->allSports->get()[0]);
    }
}
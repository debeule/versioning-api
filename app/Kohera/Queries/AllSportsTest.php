<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Kohera\Sport;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;

final class AllSportsTest extends TestCase
{
    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        KoheraSportFactory::new()->count(3)->create();
        $this->allSports = new AllSports;

        $this->assertInstanceOf(Builder::class, $this->allSports->query());
    }

    #[Test]
    public function getReturnsCollectionOfSports(): void
    {
        KoheraSportFactory::new()->count(3)->create();
        $this->allSports = new AllSports;
        
        $this->assertInstanceOf(Collection::class, $this->allSports->get());
        $this->assertInstanceOf(Sport::class, $this->allSports->get()[0]);
    }
}
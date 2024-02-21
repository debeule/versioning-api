<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Kohera\School;
use Database\Main\Factories\SchoolFactory;

final class AllSchoolsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->allSchools = new AllSchools;
    }

    /**
     * @test
     */
    public function queryReturnsBuilderInstance(): void
    {
        $this->assertInstanceOf(Builder::class, $this->allSchools->query());
    }

    /**
     * @test
     */
    public function getReturnsCollectionOfSchools(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allSchools->get());
        $this->assertInstanceOf(School::class, $this->allSchools->get()[0]);
    }
}
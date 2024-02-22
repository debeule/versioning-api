<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Kohera\School;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;

final class AllSchoolsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        KoheraSchoolFactory::new()->count(3)->create();
        
        $this->allSchools = new AllSchools;
    }

    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        $this->assertInstanceOf(Builder::class, $this->allSchools->query());
    }

    #[Test]
    public function getReturnsCollectionOfSchools(): void
    {
        $this->assertInstanceOf(Collection::class, $this->allSchools->get());
        $this->assertInstanceOf(School::class, $this->allSchools->get()[0]);
    }
}
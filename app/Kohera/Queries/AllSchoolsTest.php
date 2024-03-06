<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Kohera\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;

final class AllSchoolsTest extends TestCase
{
    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();
        
        $this->allSchools = new AllSchools;

        $this->assertInstanceOf(Builder::class, $this->allSchools->query());
    }

    #[Test]
    public function getReturnsCollectionOfSchools(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();
        
        $this->allSchools = new AllSchools;
        
        $this->assertInstanceOf(Collection::class, $this->allSchools->get());
        $this->assertInstanceOf(School::class, $this->allSchools->get()[0]);
    }
}
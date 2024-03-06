<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\School\School;
use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Attributes\Test;

final class AllSchoolsTest extends TestCase
{
    #[Test]
    public function ItCanGetAllSchools(): void
    {
        SchoolFactory::new()->count(3)->create();

        $allSchools = new AllSchools;
        $result = $allSchools->get();

        $allSchoolRecords = School::get();

        $this->assertEquals($allSchoolRecords->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfSchools(): void
    {
        SchoolFactory::new()->count(3)->create();

        $allSchools = new AllSchools;
        $result = $allSchools->get();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(School::class, $result->first());
    }
}
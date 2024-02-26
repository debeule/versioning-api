<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\Queries\AllSchools;
use App\School\School;
use Database\Main\Factories\SchoolFactory;


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
}
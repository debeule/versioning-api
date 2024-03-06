<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class SchoolByNameTest extends TestCase
{
    #[Test]
    public function ItCanGetASchoolByName(): void
    {
        $school = SchoolFactory::new()->create();

        $schoolByName = new SchoolByName;
        $result = $schoolByName->hasName($school->name)->find();

        $this->assertSame($school->name, $result->name);
    }

    #[Test]
    public function ItReturnsNullIfSchoolNotFound(): void
    {
        $schoolByName = new SchoolByName;

        $result = $schoolByName->hasName('school name')->find();

        $this->assertNull($result);
    }
}
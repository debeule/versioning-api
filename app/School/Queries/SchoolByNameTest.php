<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\Queries\SchoolByName;
use Database\Main\Factories\SchoolFactory;
use Illuminate\Database\Eloquent\Collection;

final class SchoolByNameTest extends TestCase
{
    #[Test]
    public function ItCanGetASchoolByName(): void
    {
        $school = SchoolFactory::new()->create();

        $schoolByName = new SchoolByName;
        $result = $schoolByName->find($school->name);

        $this->assertSame($school->name, $result->name);
    }

    #[Test]
    public function ItReturnsNullIfSchoolNotFound(): void
    {
        $schoolByName = new SchoolByName;

        $result = $schoolByName->find('school name');

        $this->assertNull($result);
    }
}
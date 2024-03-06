<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class SchoolByInstitutionIdTest extends TestCase
{
    #[Test]
    public function ItCanGetASchoolByInstitutionId(): void
    {
        $school = SchoolFactory::new()->create();

        $schoolByInstitutionId = new SchoolByInstitutionId;
        $result = $schoolByInstitutionId->hasInstitutionId((string) $school->institution_id)->find();

        $this->assertSame($school->name, $result->name);
    }

    #[Test]
    public function ItReturnsNullIfSchoolNotFound(): void
    {
        $schoolByInstitutionId = new SchoolByInstitutionId;

        $result = $schoolByInstitutionId->find(1234567890);

        $this->assertNull($result);
    }
}
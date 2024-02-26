<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\Queries\SchoolByInstitutionId;
use Database\Main\Factories\SchoolFactory;
use Illuminate\Database\Eloquent\Collection;

final class SchoolByInstitutionIdTest extends TestCase
{
    #[Test]
    public function ItCanGetASchoolByInstitutionId(): void
    {
        $school = SchoolFactory::new()->create();

        $schoolByInstitutionId = new SchoolByInstitutionId;
        $result = $schoolByInstitutionId->find($school->institution_id);

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
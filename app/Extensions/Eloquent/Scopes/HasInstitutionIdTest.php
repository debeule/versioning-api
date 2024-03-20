<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Main\Factories\SchoolFactory;
use App\School\School;

final class HasInstitutionIdTest extends TestCase
{
    #[Test]
    public function HasInstitutionIdScopeQueryReturnsCorrectRecord(): void
    {
        $schools = SchoolFactory::new()->count(2)->create();

        $hasInstitutionId = new HasInstitutionId((string) $schools->first()->institution_id);

        $result = School::query()->tap($hasInstitutionId)->first();

        $this->assertEquals($schools->first()->record_id, $result->record_id);
        $this->assertInstanceOf(School::class, $result);
    }
}
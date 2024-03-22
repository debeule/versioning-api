<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\School\School;
use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class HasNameTest extends TestCase
{
    #[Test]
    public function HasNameScopeQueryReturnsCorrectRecord(): void
    {
        $schools = SchoolFactory::new()->count(2)->create();

        $hasName = new HasName($schools->first()->name);

        $result = School::query()->tap($hasName)->first();

        $this->assertEquals($schools->first()->record_id, $result->record_id);
        $this->assertInstanceOf(School::class, $result);
    }
}
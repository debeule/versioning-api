<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\School\School;
use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class FromVersionTest extends TestCase
{
    #[Test]
    public function fromVersionScopeQueryReturnsCorrectRecordVersion(): void
    {
        $school = SchoolFactory::new()->create();

        $school2 = $school->replicate();
        $school2->save();

        $school->delete();

        $school2->created_at = now()->addDays(2)->toDateTimeString();

        $fromVersion = new FromVersion();
        
        $result = School::query()->when($fromVersion, $fromVersion)->get();

        $this->assertSoftDeleted($school);
        $this->assertCount(1, $result);
        $this->assertEquals($school2->record_id, $result->first()->record_id);
    }
}
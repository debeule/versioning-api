<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteSchoolTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteSchool()
    {
        $school = School::factory()->create();

        $this->dispatchSync(new SoftDeleteSchool($school));

        $this->assertSoftDeleted($school);
    }
}
<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\School;
use Database\Main\Factories\SchoolFactory;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteSchoolTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteSchool(): void
    {
        $school = SchoolFactory::new()->create();

        $this->dispatchSync(new SoftDeleteSchool($school));

        $this->assertSoftDeleted($school);
    }
}
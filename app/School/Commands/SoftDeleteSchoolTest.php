<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use Database\Main\Factories\SchoolFactory;
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
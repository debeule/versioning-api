<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\School;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use App\School\Commands\CreateSchool;
use Database\Main\Factories\AddressFactory;

final class CreateSchoolTest extends TestCase
{
    #[Test]
    public function itCanCreateSchoolFromKoheraSchool(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->schoolId())->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));

        $school = School::where('school_id', $koheraSchool->schoolId())->first();

        $this->assertInstanceOf(KoheraSchool::class, $koheraSchool);
        $this->assertInstanceOf(School::class, $school);

        $this->assertSame($koheraSchool->name(), $school->name);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->schoolId())->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));

        $this->assertFalse($this->dispatchSync(new CreateSchool($koheraSchool)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->schoolId())->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));
        $school = School::where('name', $koheraSchool->name())->first();

        $koheraSchool->Name = 'new name';
        $this->dispatchSync(new CreateSchool($koheraSchool));

        $updatedSchool = School::where('name', $koheraSchool->name())->first();

        $this->assertNotEquals($school->name, $updatedSchool->name);
        $this->assertSoftDeleted($school);

        $this->assertEquals($updatedSchool->name, $koheraSchool->name());
        $this->assertEquals($school->school_id, $updatedSchool->school_id);
    }
}
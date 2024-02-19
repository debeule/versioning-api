<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\Testing\RefreshDatabase;
use App\School\School;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use App\School\Commands\CreateSchool;
use Database\Main\Factories\AddressFactory;

final class CreateSchoolTest extends TestCase
{
    /** @test */
    public function itCreatesSchoolWhenRecordDoesNotExist(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $matchingAddress = AddressFactory::new()->withId($koheraSchool->id)->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));

        $school = School::where('school_id', $koheraSchool->schoolId())->first();

        $this->assertInstanceOf(KoheraSchool::class, $koheraSchool);
        $this->assertInstanceOf(School::class, $school);

        $this->assertSame($koheraSchool->name(), $school->name);
    }

    public function ItReturnsFalseWhenRecordExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $this->dispatchSync(new CreateSchool($koheraSchool));

        $this->assertFalse(dispatchSync(new KoheraSchool($koheraSchool)));
    }

    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();

        $this->dispatchSync(new KoheraSchool($koheraSchool));

        $oldSchoolRecord = School::where('school_id', $koheraSchool->schoolId())->first();

        $koheraSchool->Name = 'new name';
        $this->dispatchSync(new CreateSchool($koheraSchool));

        $updatedSchoolRecord = School::where('school_id', $koheraSchool->schoolId())->first();

        $this->assertTrue($oldSchoolRecord->name !== $updatedSchoolRecord->name);
        $this->assertSoftDeleted($oldSchoolRecord);

        $this->assertEquals($updatedSchoolRecord->name, $koheraSchool->name());
        $this->assertEquals($oldSchoolRecord->school_id, $updatedSchoolRecord->school_id);
    }
}
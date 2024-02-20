<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\School\School;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use App\School\Commands\CreateSchool;
use Database\Main\Factories\AddressFactory;

final class CreateSchoolTest extends TestCase
{
    private KoheraSchool $koheraSchool;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSchool = KoheraSchoolFactory::new()->create();

        //create matching address & school so that the billing profile can be created
        AddressFactory::new()->withId((string) $this->koheraSchool->id)->create();

    }

    /**
     * @test
     */
    public function itCreatesSchoolWhenRecordDoesNotExist(): void
    {
        $this->dispatchSync(new CreateSchool($this->koheraSchool));

        $school = School::where('school_id', $this->koheraSchool->schoolId())->first();

        $this->assertInstanceOf(KoheraSchool::class, $this->koheraSchool);
        $this->assertInstanceOf(School::class, $school);

        $this->assertSame($this->koheraSchool->name(), $school->name);
    }

    /**
     * @test
     */
    public function ItReturnsFalseWhenRecordExists(): void
    {
        $this->dispatchSync(new CreateSchool($this->koheraSchool));

        $this->assertFalse($this->dispatchSync(new CreateSchool($this->koheraSchool)));
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->dispatchSync(new CreateSchool($this->koheraSchool));

        $oldSchoolRecord = School::where('school_id', $this->koheraSchool->schoolId())->first();

        $this->koheraSchool->Name = 'new name';
        $this->dispatchSync(new CreateSchool($this->koheraSchool));

        $updatedSchoolRecord = School::where('school_id', $this->koheraSchool->schoolId())->first();

        $this->assertTrue($oldSchoolRecord->name !== $updatedSchoolRecord->name);
        $this->assertSoftDeleted($oldSchoolRecord);

        $this->assertEquals($updatedSchoolRecord->name, $this->koheraSchool->name());
        $this->assertEquals($oldSchoolRecord->school_id, $updatedSchoolRecord->school_id);
    }
}
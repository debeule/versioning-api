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
    private School $school;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $this->koheraSchool->schoolId())->create();
        
        $this->dispatchSync(new CreateSchool($this->koheraSchool));
        $this->school = School::where('school_id', $this->koheraSchool->schoolId())->first();


        //create matching address & school so that the billing profile can be created
    }

    /**
     * @test
     */
    public function itCanCreateSchoolFromKoheraSchool(): void
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
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $this->assertFalse($this->dispatchSync(new CreateSchool($this->koheraSchool)));
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->koheraSchool->Name = 'new name';
        $this->dispatchSync(new CreateSchool($this->koheraSchool));

        $updatedSchool = School::where('school_id', $this->koheraSchool->schoolId())->first();

        $this->assertNotEquals($this->school->name, $updatedSchool->name);
        $this->assertSoftDeleted($this->school);

        $this->assertEquals($updatedSchool->name, $this->koheraSchool->name());
        $this->assertEquals($this->school->school_id, $updatedSchool->school_id);
    }
}
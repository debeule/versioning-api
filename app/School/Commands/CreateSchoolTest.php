<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\Testing\RefreshDatabase;
use App\Sport\Commands\CreateSport;
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
        $koheraSport = KoheraSportFactory::new()->create();
        $this->dispatchSync(new CreateSport($koheraSport));

        $this->assertFalse(dispatchSync(new CreateSport($koheraSport)));
    }

    public function ItReturnsTrueWhenRecordChanged(): void
    {
        
    }

    // public function ItCreatesNewRecordVersion(): void
    // {
        
    // }
}
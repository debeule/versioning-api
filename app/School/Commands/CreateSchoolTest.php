<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use PHPUnit\Framework\Attributes\Test;

final class CreateSchoolTest extends TestCase
{
    #[Test]
    public function itCanCreateSchoolFromKoheraSchool(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));

        $school = School::where('record_id', $koheraSchool->recordId())->first();

        $this->assertInstanceOf(KoheraSchool::class, $koheraSchool);
        $this->assertInstanceOf(School::class, $school);

        $this->assertSame($koheraSchool->name(), $school->name);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));

        $this->assertFalse($this->dispatchSync(new CreateSchool($koheraSchool)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();

        $this->dispatchSync(new CreateSchool($koheraSchool));
        $school = School::where('name', $koheraSchool->name())->first();

        $koheraSchool->Name = 'new name';
        $this->dispatchSync(new CreateSchool($koheraSchool));

        $updatedSchool = School::where('name', $koheraSchool->name())->first();

        $this->assertNotEquals($school->name, $updatedSchool->name);
        $this->assertSoftDeleted($school);

        $this->assertEquals($updatedSchool->name, $koheraSchool->name());
        $this->assertEquals($school->record_id, $updatedSchool->record_id);
    }
}
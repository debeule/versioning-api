<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncSchoolsTest extends TestCase
{
    #[Test]
    public function itCreatesSchoolRecordsWhenNotExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->id)->create();

        $this->dispatchSync(new SyncSchools);
        
        $this->assertEquals(School::count(), KoheraSchool::count());
    }

    #[Test]
    public function itSoftDeletesSchoolRecordWhenDeleted(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(2)->create();

        foreach ($koheraSchools as $koheraSchool) 
        {
            AddressFactory::new()->withId('school-' . $koheraSchool->id)->create();
        }

        $this->dispatchSync(new SyncSchools);
        
        $koheraSchoolRecordId = $koheraSchools->first()->recordId();
        $koheraSchools->first()->delete();

        $this->dispatchSync(new SyncSchools);

        $this->assertSoftDeleted(School::where('record_id', $koheraSchoolRecordId)->first());
        $this->assertGreaterThan(KoheraSchool::count(), School::count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();

        $this->dispatchSync(new SyncSchools);

        $school = School::where('name', $koheraSchool->name())->first();

        $koheraSchool->Name = 'new name';
        $koheraSchool->save();

        $this->dispatchSync(new SyncSchools);

        $updatedSchool = School::where('name', $koheraSchool->name())->first();

        $this->assertNotEquals($school->name, $updatedSchool->name);
        $this->assertSoftDeleted($school);

        $this->assertEquals($updatedSchool->name, $koheraSchool->name());
        $this->assertEquals($school->record_id, $updatedSchool->record_id);
    }
}
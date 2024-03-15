<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncSchoolsTest extends TestCase
{
    #[Test]
    public function itDispatchesCreateSchoolsWhenNotExists(): void
    {
        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('school-' . $schoolRecord->id)->create();
        }

        $syncSchools = new SyncSchools();
        $syncSchools();

        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('school-' . $schoolRecord->id)->create();
        }

        $existingSchools = School::get();
        $koheraSchools = KoheraSchool::get();

        $this->assertGreaterThan($existingSchools->count(), $koheraSchools->count());

        $syncSchools = new SyncSchools();
        $syncSchools();

        $existingSchools = School::get();
        $koheraSchools = KoheraSchool::get();
        $this->assertEquals($existingSchools->count(), $koheraSchools->count());
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('school-' . $schoolRecord->id)->create();
        }

        $syncSchools = new SyncSchools();
        $syncSchools();
        
        $koheraSchool = KoheraSchool::first();
        $koheraSchoolName = $koheraSchool->name();
        $koheraSchool->delete();

        
        $syncSchools = new SyncSchools();
        $syncSchools();
            
        $this->assertSoftDeleted(School::where('name', $koheraSchoolName)->first());

        $existingSchools = School::get();
        $koheraSchools = KoheraSchool::get();

        $this->assertGreaterThan($koheraSchools->count(), $existingSchools->count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
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
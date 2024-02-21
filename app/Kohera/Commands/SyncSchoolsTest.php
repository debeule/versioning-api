<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Testing\TestCase;
use App\School\School;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use App\Kohera\Commands\SyncSchools;

final class SyncSchoolsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('school-' . $schoolRecord->id)->create();
        }

        $syncSchools = new SyncSchools();
        $syncSchools();
    }

    /**
     * @test
     */
    public function itDispatchesCreateSchoolsWhenNotExists(): void
    {
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

    /**
     * @test
     */
    public function itSoftDeletesDeletedRecords(): void
    {
        $koheraSchool = KoheraSchool::first();
        $koheraSchoolName = $koheraSchool->name();
        $koheraSchool->delete();

        
        $syncSchools = new SyncSchools();
        $syncSchools();
            
        $this->assertSoftDeleted(School::withTrashed()->where('name', $koheraSchoolName)->first());

        $existingSchools = School::withTrashed()->get();
        $koheraSchools = KoheraSchool::get();

        $this->assertGreaterThan($koheraSchools->count(), $existingSchools->count());
    }
}
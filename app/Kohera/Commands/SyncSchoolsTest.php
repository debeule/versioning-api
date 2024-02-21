<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use App\School\School;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use App\Kohera\Commands\SyncSchools;

final class SyncSchoolsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $syncSchools = new SyncSchools();
        $syncSchools();
    }

    /**
     * @test
     */
    public function itDispatchesCreateSchoolsWhenNotExists(): void
    {
        $createdKoheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        dd($createdKoheraSchools);
        foreach ($createdKoheraSchools as $createdKoheraSchool)
        {
            
            AddressFactory::new()->withId('school-' . $createdKoheraSchool->schoolId())->create();
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
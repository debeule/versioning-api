<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Kohera\School as KoheraSchool;
use App\School\Commands\CreateSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use PHPUnit\Framework\Attributes\Test;

final class SchoolDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectAdditions(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();
        }

        $this->dispatchSync(new CreateSchool($koheraSchools->first()));

        $schoolDiff = app(SchoolDiff::class);

        $result = $schoolDiff->additions();

        $this->assertInstanceOf(KoheraSchool::class, $result->first());
        $this->assertEquals(2, $result->count());
    }
    
    #[Test]
    public function itReturnsCorrectDeletions(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();
        }

        $removedKoheraSchool = $koheraSchools->first();

        $removedKoheraSchool->delete();

        $this->dispatchSync(new CreateSchool($removedKoheraSchool));

        $schoolDiff = app(SchoolDiff::class);

        $result = $schoolDiff->deletions();

        $this->assertInstanceOf(School::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('name', $removedKoheraSchool->name())->isNotEmpty());
    }
    
    #[Test]
    public function itReturnsCorrectUpdates(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            AddressFactory::new()->withId('school-' . $koheraSchool->recordId())->create();
        }

        $this->dispatchSync(new CreateSchool($koheraSchools->first()));

        $newName = "new school name";
        $koheraSchools->first()->Name = $newName;
        $koheraSchools->first()->save();

        $schoolDiff = app(SchoolDiff::class);

        $result = $schoolDiff->updates();

        $this->assertInstanceOf(KoheraSchool::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertEquals($newName, $result->first()->Name);
    }
}
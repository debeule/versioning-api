<?php

declare(strict_types=1);

namespace App\Services;

use App\Kohera\School as KoheraSchool;
use App\School\Commands\CreateSchool;
use App\School\School;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class FilterUpdatesTest extends TestCase
{
    #[Test]
    public function updateContainsUpdatedRecords(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();


        foreach($koheraSchools as $koheraSchool) 
        {
            $koheraSchoolRecordId = 'school-' . (string) $koheraSchool->recordId();
            AddressFactory::new()->withId($koheraSchoolRecordId)->create();

            $this->DispatchSync(new CreateSchool($koheraSchool));

            $koheraSchool->update(['Name' => 'Updated Name']);
        }

        $result = $this->DispatchSync(new FilterUpdates(
            School::get(),
            $koheraSchools
        ));
            
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(KoheraSchool::class, $result->first());
        $this->assertEquals(3, $result->count());
    }

    #[Test]
    public function updateDoesNotContainNewRecords(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        $koheraSchool = $koheraSchools->first();

        $koheraSchoolRecordId = 'school-' . (string) $koheraSchool->recordId();
        AddressFactory::new()->withId($koheraSchoolRecordId)->create();
        $this->DispatchSync(new CreateSchool($koheraSchool));

        $koheraSchool->name = 'Updated Name';
        $koheraSchool->save();

        $result = $this->DispatchSync(new FilterUpdates(
            School::get(),
            KoheraSchool::get()
        ));
        
        $this->assertEquals(1, $result->count());
        $this->assertEquals($koheraSchool->recordId(), $result->first()->recordId());
    }
}
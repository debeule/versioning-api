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

        $result = app(Pipeline::class)
            ->send([
                'records' => $koheraSchools,
                'existingRecords' => School::get(),
            ])
            ->through([FilterUpdatedRecords::class])
            ->thenReturn();
            
        $this->assertInstanceOf(Collection::class, $result['update']);
        $this->assertInstanceOf(KoheraSchool::class, $result['update']->first());
        $this->assertEquals(3, $result['update']->count());
    }

    #[Test]
    public function updateDoesNotContainNewOrDeletedRecords(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();

        $koheraSchoolRecordId = 'school-' . (string) $koheraSchools->first()->recordId();
        AddressFactory::new()->withId($koheraSchoolRecordId)->create();

        $this->DispatchSync(new CreateSchool($koheraSchools->first()));

        $data = [
            'records' => $koheraSchools,
            'existingRecords' => School::get(),
        ];  

        $result = app(Pipeline::class)
            ->send($data)
            ->through([FilterNewRecords::class])
            ->thenReturn();
        
        $this->assertEquals(2, $result['create']->count());
    }
}
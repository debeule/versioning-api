<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Pipeline\Pipeline;
use App\Kohera\School as KoheraSchool;
use App\School\School;
use App\School\Commands\CreateSchool;
use Illuminate\Support\Collection;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;

final class FilterNewRecordsTest extends TestCase
{
    #[Test]
    public function createContainsNewRecords(): void
    {
        $data = [
            'records' => KoheraSchoolFactory::new()->count(3)->create(),
            'existingRecords' => School::get(),
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([FilterNewRecords::class])
            ->thenReturn();
            
        $this->assertInstanceOf(Collection::class, $result['create']);
        $this->assertInstanceOf(KoheraSchool::class, $result['create']->first());
        $this->assertEquals(3, $result['create']->count());
    }

    #[Test]
    public function createDoesNotContainExistingRecords(): void
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
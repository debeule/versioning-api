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

final class FilterAdditionsTest extends TestCase
{
    #[Test]
    public function createContainsNewRecords(): void
    {
        $result = $this->DispatchSync(new FilterAdditions(
            School::get(), 
            KoheraSchoolFactory::new()->count(3)->create()
        ));
            
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(KoheraSchool::class, $result->first());
        $this->assertEquals(3, $result->count());
    }

    #[Test]
    public function createDoesNotContainExistingRecords(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();

        $koheraSchoolRecordId = 'school-' . (string) $koheraSchools->first()->recordId();
        AddressFactory::new()->withId($koheraSchoolRecordId)->create();

        $this->DispatchSync(new CreateSchool($koheraSchools->first()));

        $result = $this->DispatchSync(new FilterAdditions(
            School::get(), 
            $koheraSchools
        ));
        
        $this->assertEquals(2, $result->count());
    }
}
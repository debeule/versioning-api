<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Imports\Queries\ExternalAddresss;
use App\Kohera\Queries\AllAddresss;
use App\School\Commands\CreateAddress;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\MunicipalityFactory;
use Database\Main\Factories\AddressFactory;
use App\Kohera\Address as KoheraAddress;
use App\School\Address;

final class AddressDiffTest extends TestCase
{
    #[Test]
    public function itReturnsCorrectAdditions(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        }

        $this->dispatchSync(new CreateAddress(new KoheraAddress($koheraSchools->first())));

        $address = Address::first();
        $address->record_id = 'school-' . $koheraSchools->first()->recordId();
        $address->save();

        $addressDiff = app(AddressDiff::class);

        $result = $addressDiff->additions();

        $this->assertInstanceOf(KoheraAddress::class, $result->first());
        $this->assertEquals(5, $result->count());
    }
    
    #[Test]
    public function itReturnsCorrectDeletions(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        }

        $this->dispatchSync(new CreateAddress(new KoheraAddress($koheraSchools->first())));

        $removedKoheraSchool = $koheraSchools->first();
        $address = Address::first();
        $address->record_id = 'school-' . $removedKoheraSchool->recordId();
        $address->save();

        $removedKoheraSchool->delete();

        $addressDiff = app(AddressDiff::class);

        $result = $addressDiff->deletions();

        $this->assertInstanceOf(Address::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('record_id', 'school-' . $removedKoheraSchool->recordId())->isNotEmpty());
    }
    
    #[Test]
    public function itReturnsCorrectUpdates2(): void
    {
        $koheraSchools = KoheraSchoolFactory::new()->count(3)->create();
        foreach ($koheraSchools as $koheraSchool) 
        {
            MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        }

        $this->dispatchSync(new CreateAddress(new KoheraAddress($koheraSchools->first())));
        
        $address = Address::first();
        $address->record_id = 'school-' . $koheraSchools->first()->recordId();
        $address->save();

        $updatedKoheraSchool = $koheraSchools->first();
        $updatedKoheraSchool->address = "streetname 1";
        $updatedKoheraSchool->save();

        $addressDiff = app(AddressDiff::class);

        $result = $addressDiff->updates();

        $this->assertInstanceOf(KoheraAddress::class, $result->first());
        $this->assertEquals(1, $result->count());
        $this->assertTrue($result->where('record_id', 'school-' . $updatedKoheraSchool->recordId())->isNotEmpty());
    }
}
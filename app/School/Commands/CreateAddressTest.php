<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Testing\RefreshDatabase;
use App\School\Address;
use App\Kohera\School as KoheraSchool;
use App\Kohera\Address as KoheraAddress;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\SchoolFactory;
use Database\Main\Factories\MunicipalityFactory;

final class CreateAddressTest extends TestCase
{
    #[Test]
    public function itCanCreateAddressFromKoheraAddress(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraAddress = new KoheraAddress($koheraSchool);
        
        MunicipalityFactory::new()->withRegion()->withPostalCode($koheraSchool->Postcode)->create();
        
        $this->dispatchSync(new CreateAddress($koheraAddress));
        
        $address = Address::where('address_id', $koheraAddress->addressId())->first();

        $this->assertInstanceOf(KoheraAddress::class, $koheraAddress);
        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame($koheraAddress->addressId(), $address->address_id);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraAddress = new KoheraAddress($koheraSchool);
        
        MunicipalityFactory::new()->withRegion()->withPostalCode($koheraSchool->Postcode)->create();
        
        $this->dispatchSync(new CreateAddress($koheraAddress));
        
        $this->assertFalse($this->dispatchSync(new CreateAddress($koheraAddress)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraAddress = new KoheraAddress($koheraSchool);
        
        MunicipalityFactory::new()->withRegion()->withPostalCode($koheraSchool->Postcode)->create();
        
        $this->dispatchSync(new CreateAddress($koheraAddress));

        $oldAddress = Address::where('street_name', $koheraAddress->streetName())->first();
        $oldName = $oldAddress->name;
        
        $koheraSchool->address = 'new name';

        $this->dispatchSync(new CreateAddress(new KoheraAddress($koheraSchool)));

        $updatedAddress = Address::where('street_name', $koheraAddress->streetName())->first();
        
        $this->assertNotEquals($oldAddress->street_name, $updatedAddress->street_name);
        $this->assertSoftDeleted($oldAddress);

        $this->assertEquals($updatedAddress->street_name, $koheraAddress->streetName());
        $this->assertEquals($oldAddress->address_id, $updatedAddress->address_id);
    }
}
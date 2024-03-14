<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Address as KoheraAddress;
use App\School\Address;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\MunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;

final class CreateAddressTest extends TestCase
{
    #[Test]
    public function itCanCreateAddressFromKoheraAddress(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraAddress = new KoheraAddress($koheraSchool);
        
        MunicipalityFactory::new()->withRegion()->withPostalCode($koheraSchool->Postcode)->create();
        
        $this->dispatchSync(new CreateAddress($koheraAddress));
        
        $address = Address::where('record_id', $koheraAddress->recordId())->first();

        $this->assertInstanceOf(KoheraAddress::class, $koheraAddress);
        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame($koheraAddress->recordId(), $address->record_id);
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
        $this->assertEquals($oldAddress->record_id, $updatedAddress->record_id);
    }
}
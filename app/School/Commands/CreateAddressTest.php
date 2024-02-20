<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\Testing\RefreshDatabase;
use App\School\Address;
use App\Kohera\School as KoheraSchool;
use App\Kohera\Address as KoheraAddress;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\SchoolFactory;
use Database\Main\Factories\MunicipalityFactory;

final class CreateAddressTest extends TestCase
{
    private KoheraAddress $koheraAddress;
    private koheraSchool $koheraSchool;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSchool = KoheraSchoolFactory::new()->create();
        $this->koheraAddress = new KoheraAddress($this->koheraSchool);
        
        MunicipalityFactory::new()->withPostalCode($this->koheraSchool->Postcode)->create();
    }

    /**
     * @test
     */
    public function itCanCreateAddressFromKoheraAddress(): void
    {
        $this->dispatchSync(new CreateAddress($this->koheraAddress));
        
        $address = Address::where('address_id', $this->koheraAddress->addressId())->first();

        $this->assertInstanceOf(KoheraAddress::class, $this->koheraAddress);
        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame($this->koheraAddress->addressId(), $address->address_id);
    }

    /**
     * @test
     */
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $this->dispatchSync(new CreateAddress($this->koheraAddress));
        
        $this->assertFalse($this->dispatchSync(new CreateAddress($this->koheraAddress)));
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->dispatchSync(new CreateAddress($this->koheraAddress));

        $oldAddress = Address::where('street_name', $this->koheraAddress->streetName())->first();
        $oldName = $oldAddress->name;
        
        $this->koheraSchool->address = 'new name';

        $this->dispatchSync(new CreateAddress(new KoheraAddress($this->koheraSchool)));

        $updatedAddress = Address::where('street_name', $this->koheraAddress->streetName())->first();
        
        $this->assertNotEquals($oldAddress->street_name, $updatedAddress->street_name);
        $this->assertSoftDeleted($oldAddress);

        $this->assertEquals($updatedAddress->street_name, $this->koheraAddress->streetName());
        $this->assertEquals($oldAddress->address_id, $updatedAddress->address_id);
    }
}
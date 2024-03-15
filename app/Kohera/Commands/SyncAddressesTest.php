<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\Address as KoheraAddress;
use App\Kohera\School as KoheraSchool;
use App\School\Address;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\MunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncAddressesTest extends TestCase
{
    #[Test]
    public function itDispatchesCreateAddressesWhenNotExists(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();
        MunicipalityFactory::new()->create();

        $syncAddresses = new SyncAddresses();
        $syncAddresses();

        KoheraSchoolFactory::new()->count(3)->create();

        $existingAddresses = Address::get();
        $koheraAddresses = KoheraSchool::get();
        
        $this->assertGreaterThan($koheraAddresses->count() / 2, $existingAddresses->count());

        $syncAddresses = new SyncAddresses();
        $syncAddresses();

        $existingAddresses = Address::get();
        $koheraAddresses = KoheraSchool::get();
        $this->assertEquals($existingAddresses->count() / 2, $koheraAddresses->count());
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();
        MunicipalityFactory::new()->create();

        $syncAddresses = new SyncAddresses();
        $syncAddresses();
        
        $koheraSchool = KoheraSchool::first();  

        $koheraAddress = new KoheraAddress($koheraSchool);
        $koheraStreetName = $koheraAddress->streetName();

        $koheraSchool->delete();

        
        $syncAddresses = new SyncAddresses();
        $syncAddresses();
            
        $this->assertSoftDeleted(Address::where('street_name', $koheraStreetName)->first());

        $existingAddresses = Address::get();
        $koheraAddresses = KoheraSchool::get();

        $this->assertGreaterThan($koheraAddresses->count(), $existingAddresses->count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
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
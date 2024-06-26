<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\Address;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\MunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncAddressesTest extends TestCase
{
    #[Test]
    public function itCreatesAddressRecordsWhenNotExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();

        $this->dispatchSync(new SyncAddresses);
        
        $this->assertEquals(Address::count(), KoheraSchool::count() * 2);
    }

    #[Test]
    public function itSoftDeletesRecordsWhenDeleted(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();

        $this->dispatchSync(new SyncAddresses);
        
        $koheraSchoolRecordId = $koheraSchool->recordId();
        $koheraSchool->delete();

        $this->dispatchSync(new SyncAddresses);
        
        $this->assertSoftDeleted(Address::where('record_id', 'school-' . $koheraSchoolRecordId)->first());
        $this->assertSoftDeleted(Address::where('record_id', 'billing_profile-' . $koheraSchoolRecordId)->first());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        
        $this->dispatchSync(new SyncAddresses);

        $oldAddress = Address::where('record_id', 'school-' . $koheraSchool->recordId())->first();
        
        $streetName = 'streetname';
        $koheraSchool->address = $streetName . ' 1';
        $koheraSchool->save();

        $this->dispatchSync(new SyncAddresses);

        $updatedAddress = Address::where('street_name', $streetName)->first();
        
        $this->assertNotEquals($oldAddress->street_name, $updatedAddress->street_name);
        $this->assertSoftDeleted($oldAddress);

        $this->assertEquals($updatedAddress->street_name, $streetName);
        $this->assertEquals($oldAddress->record_id, $updatedAddress->record_id);
    }
}
<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\School\Address;
use App\Kohera\Address as KoheraAddress;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\MunicipalityFactory;
use App\Kohera\Commands\SyncAddresses;

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
}
<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\BillingProfile;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\MunicipalityFactory;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncBillingProfilesTest extends TestCase
{
    #[Test]
    public function itCreatesBillingProfileRecordsWhenNotExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();

        SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
        MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
        
        $this->assertEquals(BillingProfile::count(), KoheraSchool::count());
    }

    #[Test]
    public function itSoftDeletesRecordsWhenDeleted(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();

        SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
        MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $koheraSchoolRecordId = $koheraSchool->recordId();
        $koheraSchool->delete();
        $oldBillingProfile = BillingProfile::where('record_id', $koheraSchoolRecordId)->first();

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
            
        $this->assertSoftDeleted($oldBillingProfile);
        $this->assertGreaterThan(KoheraSchool::count(), BillingProfile::count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();

        SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
        MunicipalityFactory::new()->withPostalCode($koheraSchool->Postcode)->create();
        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();
        
        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $oldBillingProfile = BillingProfile::where('record_id', $koheraSchool->recordId())->first();
        
        $name = 'new name';
        $koheraSchool->Facturatie_Naam = $name;
        $koheraSchool->save();
        
        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $updatedBillingProfile = BillingProfile::where('name', $name)->first();
        
        $this->assertNotEquals($oldBillingProfile->name, $updatedBillingProfile->name);
        $this->assertSoftDeleted($oldBillingProfile);

        $this->assertEquals($updatedBillingProfile->name, $name);
        $this->assertEquals($oldBillingProfile->record_id, $updatedBillingProfile->record_id);
    }
}
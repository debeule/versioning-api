<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\Kohera\School as KoheraSchool;
use App\School\BillingProfile;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class SyncBillingProfilesTest extends TestCase
{
    #[Test]
    public function itDispatchesCreateBillingProfilesWhenNotExists(): void
    {
        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('billing_profile-' . $schoolRecord->id)->create();
            $school = SchoolFactory::new()->withId( (string) $schoolRecord->id)->create();
        }

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('billing_profile-' . $schoolRecord->id)->create();
            $school = SchoolFactory::new()->withId( (string) $schoolRecord->id)->create();
        }
        
        $existingBillingProfiles = BillingProfile::get();
        $koheraBillingProfiles = KoheraSchool::get();
        
        $this->assertGreaterThan($existingBillingProfiles->count(), $koheraBillingProfiles->count());

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $existingBillingProfiles = BillingProfile::get();
        $koheraBillingProfiles = KoheraSchool::get();
        $this->assertEquals($existingBillingProfiles->count(), $koheraBillingProfiles->count());
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('billing_profile-' . $schoolRecord->id)->create();
            $school = SchoolFactory::new()->withId( (string) $schoolRecord->id)->create();
        }

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $koheraSchool = KoheraSchool::first();  

        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);
        $koheraBillingProfileName = $koheraBillingProfile->name();

        $koheraSchool->delete();

        
        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
            
        $this->assertSoftDeleted(BillingProfile::where('name', $koheraBillingProfileName)->first());

        $existingBillingProfiles = BillingProfile::get();
        $koheraBillingProfiles = KoheraSchool::get();

        $this->assertGreaterThan($koheraBillingProfiles->count(), $existingBillingProfiles->count());
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfChangedAndExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->recordId())->create();
        SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
        
        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $oldBillingProfile = BillingProfile::where('name', $koheraBillingProfile->name())->first();
        $oldName = $oldBillingProfile->name;
        
        $koheraSchool->Facturatie_Naam = 'new name';

        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($koheraSchool)));

        $updatedBillingProfile = BillingProfile::where('name', $koheraBillingProfile->name())->first();
        
        $this->assertNotEquals($oldBillingProfile->name, $updatedBillingProfile->name);
        $this->assertSoftDeleted($oldBillingProfile);

        $this->assertEquals($updatedBillingProfile->name, $koheraBillingProfile->name());
        $this->assertEquals($oldBillingProfile->record_id, $updatedBillingProfile->record_id);
    }
}
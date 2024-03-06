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
}
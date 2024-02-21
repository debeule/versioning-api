<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Testing\TestCase;
use App\School\BillingProfile;
use App\Kohera\BillingProfile as KoheraBillingProfile;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\SchoolFactory;
use Database\Main\Factories\AddressFactory;
use App\Kohera\Commands\SyncBillingProfiles;

final class SyncBillingProfilesTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('billing_profile-' . $schoolRecord->id)->create();
            $school = SchoolFactory::new()->withId( (string) $schoolRecord->id)->create();
        }

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
    }

    /**
     * @test
     */
    public function itDispatchesCreateBillingProfilesWhenNotExists(): void
    {
        $schoolRecords = KoheraSchoolFactory::new()->count(3)->create();

        foreach ($schoolRecords as $schoolRecord) 
        {
            AddressFactory::new()->withId('billing_profile-' . $schoolRecord->id)->create();
            $school = SchoolFactory::new()->withId( (string) $schoolRecord->id)->create();
        }
        
        $existingBillingProfiles = BillingProfile::get();
        $koheraBillingProfiles = KoheraBillingProfile::get();
        dd
        $this->assertGreaterThan($existingBillingProfiles->count(), $koheraBillingProfiles->count());

        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();

        $existingBillingProfiles = BillingProfile::get();
        $koheraBillingProfiles = KoheraBillingProfile::get();
        $this->assertEquals($existingBillingProfiles->count(), $koheraBillingProfiles->count());
    }

    /**
     * @test
     */
    public function itSoftDeletesDeletedRecords(): void
    {
        $koheraBillingProfile = KoheraBillingProfile::first();
        $koheraBillingProfileName = $koheraBillingProfile->name();
        $koheraBillingProfile->delete();

        
        $syncBillingProfiles = new SyncBillingProfiles();
        $syncBillingProfiles();
            
        $this->assertSoftDeleted(BillingProfile::withTrashed()->where('name', $koheraBillingProfileName)->first());

        $existingBillingProfiles = BillingProfile::withTrashed()->get();
        $koheraBillingProfiles = KoheraBillingProfile::get();

        $this->assertGreaterThan($koheraBillingProfiles->count(), $existingBillingProfiles->count());
    }
}
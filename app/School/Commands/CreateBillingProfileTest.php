<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\Testing\RefreshDatabase;
use App\School\BillingProfile;
use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\Kohera\School as koheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\SchoolFactory;
use App\School\Commands\CreateBillingProfile;

final class CreateBillingProfileTest extends TestCase
{
    private KoheraBillingProfile $koheraBillingProfile;
    private koheraSchool $koheraSchool;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSchool = KoheraSchoolFactory::new()->create();
        $this->koheraBillingProfile = new KoheraBillingProfile($this->koheraSchool);

        //create matching address & school so that the billing profile can be created
        AddressFactory::new()->withId('billing_profile-' . $this->koheraSchool->schoolId())->create();
        SchoolFactory::new()->withId((string) $this->koheraSchool->schoolId())->create();
        
        $this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile));
    }

    /**
     * @test
     */
    public function itCanCreateBillingProfileFromKoheraBillingProfile(): void
    {
        $billingProfile = BillingProfile::where('billing_profile_id', $this->koheraBillingProfile->billingProfileId())->first();

        $this->assertInstanceOf(KoheraBillingProfile::class, $this->koheraBillingProfile);
        $this->assertInstanceOf(BillingProfile::class, $billingProfile);

        $this->assertSame($this->koheraBillingProfile->billingProfileId(), $billingProfile->billing_profile_id);
    }

    /**
     * @test
     */
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $this->assertFalse($this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile)));
    }

    /**
     * @test
     */
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $oldBillingProfileRecord = BillingProfile::where('name', $this->koheraBillingProfile->name())->first();
        $oldName = $this->koheraBillingProfile->name();
        
        $this->koheraSchool->Facturatie_Naam = 'new name';
        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($this->koheraSchool)));
        $updatedBillingProfileRecord = BillingProfile::where('name', $this->koheraBillingProfile->name())->first();
        
        $this->assertNotEquals($oldBillingProfileRecord->name, $updatedBillingProfileRecord->name);
        $this->assertSoftDeleted($oldBillingProfileRecord);

        $this->assertEquals($updatedBillingProfileRecord->name, $this->koheraBillingProfile->name());
        $this->assertEquals($oldBillingProfileRecord->billing_profile_id, $updatedBillingProfileRecord->billing_profile_id);
    }
}
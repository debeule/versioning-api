<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\Testing\RefreshDatabase;
use App\School\BillingProfile;
use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\Kohera\School as KoheraSchool;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\SchoolFactory;
use App\School\Commands\CreateBillingProfile;

final class CreateBillingProfileTest extends TestCase
{
    private KoheraBillingProfile $koheraBillingProfile;

    public function setUp(): void
    {
        parent::setUp();

        $koheraSchool = KoheraSchoolFactory::new()->create();
        $this->koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        //create matching address & school so that the billing profile can be created
        AddressFactory::new()->withId('billing_profile-' . $this->koheraBillingProfile->billingProfileId())->create();
        SchoolFactory::new()->withId((string) $this->koheraBillingProfile->billingProfileId())->create();
    }

    /**
     * @test
     */
    public function itCanCreateBillingProfileFromKoheraBillingProfile(): void
    {
        $this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile));

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
        $this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile));

        $this->assertFalse($this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile)));
    }

    // /**
    //  * @test
    //  */
    // public function ItCreatesNewRecordVersionIfExists(): void
    // {
    //     $this->koheraBillingProfile = KoheraSchoolFactory::new()->create();

    //     $this->dispatchSync(new KoheraSchool($this->koheraBillingProfile));

    //     $oldSchoolRecord = School::where('school_id', $this->koheraBillingProfile->schoolId())->first();

    //     $this->koheraBillingProfile->Name = 'new name';
    //     $this->dispatchSync(new CreateSchool($this->koheraBillingProfile));

    //     $updatedSchoolRecord = School::where('school_id', $this->koheraBillingProfile->schoolId())->first();

    //     $this->assertTrue($oldSchoolRecord->name !== $updatedSchoolRecord->name);
    //     $this->assertSoftDeleted($oldSchoolRecord);

    //     $this->assertEquals($updatedSchoolRecord->name, $this->koheraBillingProfile->name());
    //     $this->assertEquals($oldSchoolRecord->school_id, $updatedSchoolRecord->school_id);
    // }
}
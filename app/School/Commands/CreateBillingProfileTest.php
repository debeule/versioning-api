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
    private KoheraSchool $koheraSchool;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSchool = KoheraSchoolFactory::new()->create();

        //create matching address & school so that the billing profile can be created
        AddressFactory::new()->withId('billing_profile-' . $this->koheraSchool->id)->create();
        SchoolFactory::new()->withId((string) $this->koheraSchool->id)->create();
    }

    /**
     * @test
     */
    public function itCreatesSchoolWhenRecordDoesNotExist(): void
    {
        $koheraBillingProfile = new KoheraBillingProfile($this->koheraSchool);

        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $billingProfile = BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->first();

        $this->assertInstanceOf(KoheraBillingProfile::class, $koheraBillingProfile);
        $this->assertInstanceOf(BillingProfile::class, $billingProfile);

        $this->assertSame($koheraBillingProfile->billingProfileId(), $billingProfile->billing_profile_id);
    }

    /**
     * @test
     */
    // public function ItReturnsFalseWhenRecordExists(): void
    // {
    //     $this->koheraSchool = KoheraSchoolFactory::new()->create();
    //     $this->dispatchSync(new CreateSchool($this->koheraSchool));

    //     $this->assertFalse(dispatchSync(new KoheraSchool($this->koheraSchool)));
    // }

    // /**
    //  * @test
    //  */
    // public function ItCreatesNewRecordVersionIfExists(): void
    // {
    //     $this->koheraSchool = KoheraSchoolFactory::new()->create();

    //     $this->dispatchSync(new KoheraSchool($this->koheraSchool));

    //     $oldSchoolRecord = School::where('school_id', $this->koheraSchool->schoolId())->first();

    //     $this->koheraSchool->Name = 'new name';
    //     $this->dispatchSync(new CreateSchool($this->koheraSchool));

    //     $updatedSchoolRecord = School::where('school_id', $this->koheraSchool->schoolId())->first();

    //     $this->assertTrue($oldSchoolRecord->name !== $updatedSchoolRecord->name);
    //     $this->assertSoftDeleted($oldSchoolRecord);

    //     $this->assertEquals($updatedSchoolRecord->name, $this->koheraSchool->name());
    //     $this->assertEquals($oldSchoolRecord->school_id, $updatedSchoolRecord->school_id);
    // }
}
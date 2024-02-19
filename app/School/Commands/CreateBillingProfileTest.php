<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use App\Testing\RefreshDatabase;
use App\School\BillingProfile;
use App\Kohera\BillingProfile as KoheraBillingProfile;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use App\School\Commands\CreateBillingProfile;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\SchoolFactory;

final class CreateBillingProfileTest extends TestCase
{
    /**
     * @test
     */
    public function itCreatesSchoolWhenRecordDoesNotExist(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $matchingAddress = AddressFactory::new()->withId('billing_profile-' . $koheraSchool->id)->create();

        $school = SchoolFactory::new()->withId((string) $koheraSchool->id)->create();

        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

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
    //     $koheraSchool = KoheraSchoolFactory::new()->create();
    //     $this->dispatchSync(new CreateSchool($koheraSchool));

    //     $this->assertFalse(dispatchSync(new KoheraSchool($koheraSchool)));
    // }

    // /**
    //  * @test
    //  */
    // public function ItCreatesNewRecordVersionIfExists(): void
    // {
    //     $koheraSchool = KoheraSchoolFactory::new()->create();

    //     $this->dispatchSync(new KoheraSchool($koheraSchool));

    //     $oldSchoolRecord = School::where('school_id', $koheraSchool->schoolId())->first();

    //     $koheraSchool->Name = 'new name';
    //     $this->dispatchSync(new CreateSchool($koheraSchool));

    //     $updatedSchoolRecord = School::where('school_id', $koheraSchool->schoolId())->first();

    //     $this->assertTrue($oldSchoolRecord->name !== $updatedSchoolRecord->name);
    //     $this->assertSoftDeleted($oldSchoolRecord);

    //     $this->assertEquals($updatedSchoolRecord->name, $koheraSchool->name());
    //     $this->assertEquals($oldSchoolRecord->school_id, $updatedSchoolRecord->school_id);
    // }
}
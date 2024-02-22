<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
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
    #[Test]
    public function itCanCreateBillingProfileFromKoheraBillingProfile(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->schoolId())->create();
        SchoolFactory::new()->withId((string) $koheraSchool->schoolId())->create();

        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $billingProfile = BillingProfile::where('billing_profile_id', $koheraBillingProfile->billingProfileId())->first();

        $this->assertInstanceOf(KoheraBillingProfile::class, $koheraBillingProfile);
        $this->assertInstanceOf(BillingProfile::class, $billingProfile);

        $this->assertSame($koheraBillingProfile->billingProfileId(), $billingProfile->billing_profile_id);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->schoolId())->create();
        SchoolFactory::new()->withId((string) $koheraSchool->schoolId())->create();
        
        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $this->assertFalse($this->dispatchSync(new CreateBillingProfile($koheraBillingProfile)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->schoolId())->create();
        SchoolFactory::new()->withId((string) $koheraSchool->schoolId())->create();
        
        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $oldBillingProfile = BillingProfile::where('name', $koheraBillingProfile->name())->first();
        $oldName = $oldBillingProfile->name;
        
        $koheraSchool->Facturatie_Naam = 'new name';

        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($koheraSchool)));

        $updatedBillingProfile = BillingProfile::where('name', $koheraBillingProfile->name())->first();
        
        $this->assertNotEquals($oldBillingProfile->name, $updatedBillingProfile->name);
        $this->assertSoftDeleted($oldBillingProfile);

        $this->assertEquals($updatedBillingProfile->name, $koheraBillingProfile->name());
        $this->assertEquals($oldBillingProfile->billing_profile_id, $updatedBillingProfile->billing_profile_id);
    }
}
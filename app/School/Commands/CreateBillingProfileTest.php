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
    private KoheraBillingProfile $koheraBillingProfile;
    private KoheraSchool $koheraSchool;

    public function setUp(): void
    {
        parent::setUp();

        $this->koheraSchool = KoheraSchoolFactory::new()->create();
        $this->koheraBillingProfile = new KoheraBillingProfile($this->koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $this->koheraSchool->schoolId())->create();
        SchoolFactory::new()->withId((string) $this->koheraSchool->schoolId())->create();
    }

    #[Test]
    public function itCanCreateBillingProfileFromKoheraBillingProfile(): void
    {
        $this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile));

        $billingProfile = BillingProfile::where('billing_profile_id', $this->koheraBillingProfile->billingProfileId())->first();

        $this->assertInstanceOf(KoheraBillingProfile::class, $this->koheraBillingProfile);
        $this->assertInstanceOf(BillingProfile::class, $billingProfile);

        $this->assertSame($this->koheraBillingProfile->billingProfileId(), $billingProfile->billing_profile_id);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile));

        $this->assertFalse($this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
    {
        $this->dispatchSync(new CreateBillingProfile($this->koheraBillingProfile));

        $oldBillingProfile = BillingProfile::where('name', $this->koheraBillingProfile->name())->first();
        $oldName = $oldBillingProfile->name;
        
        $this->koheraSchool->Facturatie_Naam = 'new name';

        $this->dispatchSync(new CreateBillingProfile(new KoheraBillingProfile($this->koheraSchool)));

        $updatedBillingProfile = BillingProfile::where('name', $this->koheraBillingProfile->name())->first();
        
        $this->assertNotEquals($oldBillingProfile->name, $updatedBillingProfile->name);
        $this->assertSoftDeleted($oldBillingProfile);

        $this->assertEquals($updatedBillingProfile->name, $this->koheraBillingProfile->name());
        $this->assertEquals($oldBillingProfile->billing_profile_id, $updatedBillingProfile->billing_profile_id);
    }
}
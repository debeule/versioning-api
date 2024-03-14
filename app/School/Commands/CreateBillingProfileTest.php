<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\School\BillingProfile;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\AddressFactory;
use Database\Main\Factories\SchoolFactory;
use PHPUnit\Framework\Attributes\Test;

final class CreateBillingProfileTest extends TestCase
{
    #[Test]
    public function itCanCreateBillingProfileFromKoheraBillingProfile(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->recordId())->create();
        SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();

        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $billingProfile = BillingProfile::where('record_id', $koheraBillingProfile->recordId())->first();

        $this->assertInstanceOf(KoheraBillingProfile::class, $koheraBillingProfile);
        $this->assertInstanceOf(BillingProfile::class, $billingProfile);

        $this->assertSame($koheraBillingProfile->recordId(), $billingProfile->record_id);
    }

    #[Test]
    public function ItReturnsFalseWhenExactRecordExists(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraBillingProfile = new KoheraBillingProfile($koheraSchool);

        AddressFactory::new()->withId('billing_profile-' . $koheraSchool->recordId())->create();
        SchoolFactory::new()->withId((string) $koheraSchool->recordId())->create();
        
        $this->dispatchSync(new CreateBillingProfile($koheraBillingProfile));

        $this->assertFalse($this->dispatchSync(new CreateBillingProfile($koheraBillingProfile)));
    }

    #[Test]
    public function ItCreatesNewRecordVersionIfExists(): void
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
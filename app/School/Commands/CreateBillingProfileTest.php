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
}
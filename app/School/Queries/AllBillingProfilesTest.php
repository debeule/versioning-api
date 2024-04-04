<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\School\billingProfile;
use App\Testing\TestCase;
use Database\Main\Factories\billingProfileFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class AllbillingProfilesTest extends TestCase
{
    #[Test]
    public function ItCanGetAllbillingProfiles(): void
    {
        billingProfileFactory::new()->count(3)->create();

        $allbillingProfiles = new AllbillingProfiles;
        $result = $allbillingProfiles->get();

        $allbillingProfileRecords = billingProfile::get();

        $this->assertEquals($allbillingProfileRecords->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfbillingProfiles(): void
    {
        billingProfileFactory::new()->count(3)->create();

        $allbillingProfiles = new AllbillingProfiles;
        $result = $allbillingProfiles->get();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(billingProfile::class, $result->first());
    }
}
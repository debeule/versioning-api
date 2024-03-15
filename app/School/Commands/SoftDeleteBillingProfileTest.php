<?php

declare(strict_types=1);

namespace App\BillingProfile\Commands;

use App\Kohera\BillingProfile as KoheraBillingProfile;
use App\School\BillingProfile;
use App\Testing\TestCase;
use Database\Kohera\Factories\BillingProfileFactory as KoheraBillingProfileFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteBillingProfileTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteBillingProfile()
    {
        $billingProfile = BillingProfile::factory()->create();

        $this->dispatchSync(new SoftDeleteBillingProfile($billingProfile));

        $this->assertSoftDeleted($billingProfile);
    }
}
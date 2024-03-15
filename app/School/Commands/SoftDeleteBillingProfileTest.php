<?php

declare(strict_types=1);

namespace App\BillingProfile\Commands;

use App\School\BillingProfile;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteBillingProfileTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteBillingProfile(): void
    {
        $billingProfile = BillingProfile::factory()->create();

        $this->dispatchSync(new SoftDeleteBillingProfile($billingProfile));

        $this->assertSoftDeleted($billingProfile);
    }
}
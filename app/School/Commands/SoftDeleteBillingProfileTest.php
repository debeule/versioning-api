<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\School\BillingProfile;
use Database\Main\Factories\BillingProfileFactory;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteBillingProfileTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteBillingProfile(): void
    {
        $billingProfile = BillingProfileFactory::new()->create();

        $this->dispatchSync(new SoftDeleteBillingProfile($billingProfile));

        $this->assertSoftDeleted($billingProfile);
    }
}
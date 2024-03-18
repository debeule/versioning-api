<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use Database\Main\Factories\BillingProfileFactory;
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
<?php

declare(strict_types=1);

namespace App\Address\Commands;

use App\school\Address;
use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteAddressTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteAddress(): void
    {
        $address = Address::factory()->create();

        $this->dispatchSync(new SoftDeleteAddress($address));

        $this->assertSoftDeleted($address);
    }
}
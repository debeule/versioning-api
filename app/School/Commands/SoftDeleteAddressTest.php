<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Testing\TestCase;
use Database\Main\Factories\AddressFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteAddressTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteAddress(): void
    {
        $address = AddressFactory::new()->create();

        $this->dispatchSync(new SoftDeleteAddress($address));

        $this->assertSoftDeleted($address);
    }
}
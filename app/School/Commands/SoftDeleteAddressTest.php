<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\school\Address;
use Database\Main\Factories\AddressFactory;
use App\Testing\TestCase;
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
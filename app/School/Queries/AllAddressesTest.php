<?php

declare(strict_types=1);

namespace App\School\Queries;

use App\School\Address;
use App\Testing\TestCase;
use Database\Main\Factories\AddressFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class AllAddressesTest extends TestCase
{
    #[Test]
    public function ItCanGetAllAddresses(): void
    {
        AddressFactory::new()->count(3)->create();

        $allAddresses = new AllAddresses;
        $result = $allAddresses->get();

        $allAddressRecords = Address::get();

        $this->assertEquals($allAddressRecords->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfAddresses(): void
    {
        AddressFactory::new()->count(3)->create();

        $allAddresses = new AllAddresses;
        $result = $allAddresses->get();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Address::class, $result->first());
    }
}
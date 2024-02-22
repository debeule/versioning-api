<?php

declare(strict_types=1);

namespace App\Kohera\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use App\Kohera\Address;
use Database\Kohera\Factories\SchoolFactory  as KoheraSchoolFactory;

final class AllAddressesTest extends TestCase
{
    #[Test]
    public function queryReturnsBuilderInstance(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();

        $this->allAddresses = new AllAddresses;

        $this->assertInstanceOf(Builder::class, $this->allAddresses->query());
    }

    #[Test]
    public function getReturnsCollectionOfAddresses(): void
    {
        KoheraSchoolFactory::new()->count(3)->create();

        $this->allAddresses = new AllAddresses;
        
        $this->assertInstanceOf(Collection::class, $this->allAddresses->get());
        $this->assertInstanceOf(Address::class, $this->allAddresses->get()[0]);
    }
}
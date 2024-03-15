<?php

declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\Address as KoheraAddress;
use App\School\Address;
use App\Testing\TestCase;
use Database\Kohera\Factories\SchoolFactory as KoheraSchoolFactory;
use Database\Main\Factories\MunicipalityFactory;
use PHPUnit\Framework\Attributes\Test;

final class CreateAddressTest extends TestCase
{
    #[Test]
    public function itCanCreateAddressFromKoheraAddress(): void
    {
        $koheraSchool = KoheraSchoolFactory::new()->create();
        $koheraAddress = new KoheraAddress($koheraSchool);
        
        MunicipalityFactory::new()->withRegion()->withPostalCode($koheraSchool->Postcode)->create();
        
        $this->dispatchSync(new CreateAddress($koheraAddress));
        
        $address = Address::where('record_id', $koheraAddress->recordId())->first();

        $this->assertInstanceOf(KoheraAddress::class, $koheraAddress);
        $this->assertInstanceOf(Address::class, $address);

        $this->assertSame($koheraAddress->recordId(), $address->record_id);
    }
}
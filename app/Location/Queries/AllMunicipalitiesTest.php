<?php

declare(strict_types=1);

namespace App\Location\Queries;

use App\Location\Municipality;
use App\Testing\TestCase;
use Database\Main\Factories\MunicipalityFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class AllMunicipalitiesTest extends TestCase
{
    #[Test]
    public function ItCanGetAllMunicipalities(): void
    {
        MunicipalityFactory::new()->count(3)->create();

        $allMunicipalities = new AllMunicipalities;

        $result = $allMunicipalities->find();

        $allMunicipalityRecords = Municipality::get();

        $this->assertEquals($allMunicipalityRecords->count(), $result->count());
    }

    #[Test]
    public function ItReturnsCollectionOfMunicipalities(): void
    {
        MunicipalityFactory::new()->count(3)->create();

        $allMunicipalities = new AllMunicipalities;
        $result = $allMunicipalities->find();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertInstanceOf(Municipality::class, $result->first());
    }
}
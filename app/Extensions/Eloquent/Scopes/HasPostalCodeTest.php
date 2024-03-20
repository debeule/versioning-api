<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Main\Factories\MunicipalityFactory;
use App\Location\Municipality;

final class HasPostalCodeTest extends TestCase
{
    #[Test]
    public function HasPostalCodeScopeQueryReturnsCorrectRecord(): void
    {
        $municipalities = MunicipalityFactory::new()->count(2)->create();

        $hasPostalCode = new HasPostalCode($municipalities->first()->postal_code);

        $result = Municipality::query()->tap($hasPostalCode)->first();

        $this->assertEquals($municipalities->first()->record_id, $result->record_id);
        $this->assertInstanceOf(Municipality::class, $result);
    }
}
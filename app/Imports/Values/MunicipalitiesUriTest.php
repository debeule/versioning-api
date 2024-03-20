<?php

declare(strict_types=1);

namespace App\Imports\Values;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class MunicipalitiesUriTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $this->assertTrue(false);
    }

    #[Test]
    public function itReturnsDefaultValue(): void
    {
        $municipalitiesUri = new MunicipalitiesUri();

        $this->assertEquals('/excel/municipalities.xls', (string) $municipalitiesUri);
    }

    #[Test]
    public function itReturnsCustomValues(): void
    {
        $customPath = '/custom/';
        $customFileName = 'custom_municipalities.xls';

        $municipalitiesUri = new MunicipalitiesUri($customPath, $customFileName);

        $this->assertEquals($customPath . $customFileName, (string)$municipalitiesUri);
    }
}
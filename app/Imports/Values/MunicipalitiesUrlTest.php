<?php

declare(strict_types=1);

namespace App\Imports\Values;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class MunicipalitiesUrlTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $municipalitiesUrl = new MunicipalitiesUrl();

        $this->assertIsString((string) $municipalitiesUrl);
    }

    #[Test]
    public function itReturnsDefaultValue(): void
    {
        $municipalitiesUrl = new MunicipalitiesUrl();

        $this->assertEquals('/excel/municipalities.xls', (string) $municipalitiesUrl);
    }

    #[Test]
    public function itReturnsCustomValues(): void
    {
        $customPath = '/custom/';
        $customFileName = 'custom_municipalities.xls';

        $municipalitiesUrl = new MunicipalitiesUrl($customPath, $customFileName);

        $this->assertEquals($customPath . $customFileName, (string)$municipalitiesUrl);
    }
}
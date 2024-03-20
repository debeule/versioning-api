<?php

declare(strict_types=1);

namespace App\Imports\Values;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class ProvinceGroupTest extends TestCase
{
    #[Test]
    public function itReturnsArray(): void
    {
        $allProvinces = ProvinceGroup::allProvinces()->get();

        $this->assertIsArray($allProvinces);
    }

    #[Test]
    public function flemishProvincesReturnsExpectedCount(): void
    {
        $expected = ['antwerpen', 'limburg', 'oost-vlaanderen', 'vlaams-brabant', 'west-vlaanderen'];

        $flemishProvinces = ProvinceGroup::flemishProvinces()->get();

        $this->assertCount(5, $flemishProvinces);
        $this->assertEquals($expected, $flemishProvinces);
    }

    #[Test]
    public function allProvincesReturnsExpected(): void
    {
        $expected = [
            'antwerpen', 
            'limburg', 
            'oost-vlaanderen', 
            'vlaams-brabant', 
            'west-vlaanderen', 
            'waals-brabant', 
            'henegouwen', 
            'luik', 
            'luxemburg', 
            'namen', 
            'brussel'
        ];

        $allProvinces = ProvinceGroup::allProvinces()->get();

        $this->assertCount(11, $allProvinces);
        $this->assertEquals($expected, $allProvinces);
    }
}
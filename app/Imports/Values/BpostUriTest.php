<?php

declare(strict_types=1);

namespace App\Imports\Values;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class BpostUriTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $bpostUri = new BpostUri();

        $this->assertIsString((string) $bpostUri);
    }

    #[Test]
    public function itReturnsDefaultValue(): void
    {
        $bpostUri = new BpostUri();

        $this->assertEquals('www.bpost2.be/zipcodes/files/zipcodes_alpha_nl_new.xls', (string) $bpostUri);
    }

    #[Test]
    public function itReturnsCustomValues(): void
    {
        $customPath = 'custom.website.be';
        $customSubpage = '/test';

        $bpostUri = new BpostUri($customPath, $customSubpage);

        $this->assertEquals($customPath . $customSubpage, (string)$bpostUri);
    }
}
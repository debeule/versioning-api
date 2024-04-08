<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\Test;
use PhpUnit\Framework\TestCase;

final class VersionTest extends TestCase
{
    #[Test]
    public function itReturnsStringOnDefaultTime(): void
    {
        $version = new Version();

        $this->assertIsString((string) $version);
    }
    
    #[Test]
    public function itReturnsCorrectDateFromInput(): void
    {
        $date = CarbonImmutable::create(2021, 1, 1);


        $version = new Version($date);

        $this->assertEquals('2021-01-01', (string) $version);
    }
}
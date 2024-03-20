<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SanitizerTest extends TestCase
{
    #[Test]
    public function testStringSanitization(): void
    {
        $sanitizer = Sanitizer::input("   Test Value   ");
        $this->assertSame("Test Value", $sanitizer->value());
    }

    #[Test]
    public function testIntSanitization(): void
    {
        $sanitizer = Sanitizer::input("123");
        $this->assertSame(123, $sanitizer->numericValue());
    }
}
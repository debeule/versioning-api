<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class HasPostalCodeTest extends TestCase
{
    #[Test]
    public function HasPostalCodeQueryReturnsCorrectRecord(): void
    {
        $this->assertTrue(false);
    }
}
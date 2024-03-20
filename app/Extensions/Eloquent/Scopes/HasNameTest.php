<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class HasNameTest extends TestCase
{
    #[Test]
    public function HasNameQueryReturnsCorrectRecord(): void
    {
        $this->assertTrue(false);
    }
}
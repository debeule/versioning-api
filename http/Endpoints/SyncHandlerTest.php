<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class SyncHandlerTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $this->assertTrue(false);
    }

}
<?php

declare(strict_types=1);

namespace App\Imports\Values;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class BpostUriTest extends TestCase
{
    #[Test]
    public function itReturnsValidUrl(): void
    {
        $this->assertTrue(false);
    }
}
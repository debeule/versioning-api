<?php

declare(strict_types=1);

namespace App\Imports\Values;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class ProvinceGroupTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $this->assertTrue(false);
    }
}
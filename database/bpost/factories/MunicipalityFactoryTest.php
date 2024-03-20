<?php

declare(strict_types=1);

namespace Database\Bpost\Factories;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

final class MunicipalityFactoryTest extends TestCase
{
    #[Test]
    public function itReturnsString(): void
    {
        $this->assertTrue(false);
    }

}
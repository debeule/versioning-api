<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

final class HasNameTest extends TestCase
{
    #[Test]
    public function HasNameQueryReturnsCorrectRecord(): void
    {
        $this->assertTrue(false);
    }
}
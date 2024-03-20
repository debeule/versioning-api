<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

final class SanitizerTest extends TestCase
{
    #[Test]
    public function HasRegionNumberQueryReturnsCorrectRecord(): void
    {
        $this->assertTrue(false);
    }
}
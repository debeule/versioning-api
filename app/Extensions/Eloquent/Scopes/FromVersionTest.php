<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Bpost\Municipality;
use App\Testing\TestCase;
use Database\Bpost\Factories\MunicipalityFactory as BpostMunicipalityFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

final class FromVersionTest extends TestCase
{
    #[Test]
    public function fromVersionQueryReturnsCorrectRecordVersion(): void
    {
        $this->assertTrue(false);
    }
}
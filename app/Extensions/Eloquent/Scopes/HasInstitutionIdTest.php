<?php

declare(strict_types=1);

namespace App\Extensions\Eloquent\Scopes;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class HasInstitutionIdTest extends TestCase
{
    #[Test]
    public function HasInstitutionIdQueryReturnsCorrectRecord(): void
    {
        $this->assertTrue(false);
    }
}
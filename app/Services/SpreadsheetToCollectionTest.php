<?php

declare(strict_types=1);

namespace App\Services;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Collection;
use App\Location\Municipality;

final class SpreadsheetToCollectionTest extends TestCase
{
    private string $storagePath = 'excel/TestFile.xls';

    #[Test]
    public function itReturnsCollection(): void
    {
        $result = SpreadsheetToCollection::setup($this->storagePath, Municipality::class)->pipe();

        $this->assertInstanceOf(Collection::class, $result);
    }
}
<?php

declare(strict_types=1);

namespace App\Services;

use App\Location\Municipality;
use App\Testing\TestCase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;

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
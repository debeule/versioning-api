<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Testing\TestCase;
use Database\Main\Factories\SportFactory;
use PHPUnit\Framework\Attributes\Test;

final class SoftDeleteSportTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteSport(): void
    {
        $sport = SportFactory::new()->create();

        $this->dispatchSync(new SoftDeleteSport($sport));

        $this->assertSoftDeleted($sport);
    }
}
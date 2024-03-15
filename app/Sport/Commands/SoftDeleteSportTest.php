<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;
use App\Testing\TestCase;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use PHPUnit\Framework\Attributes\Test;


final class SoftDeleteSportTest extends TestCase
{
    #[Test]
    public function itCanSoftDeleteSport()
    {
        $sport = Sport::factory()->create();

        $this->dispatchSync(new SoftDeleteSport($sport));

        $this->assertSoftDeleted($sport);
    }
}
<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Testing\TestCase;
use Database\Main\Factories\SportFactory;
use PHPUnit\Framework\Attributes\Test;


final class SportByNameTest extends TestCase
{
    #[Test]
    public function ItCanGetASportByName(): void
    {
        $sportName = 'Football';

        $sport = SportFactory::new()->withName($sportName)->create();

        $SportByName = new SportByName;
        $result = $SportByName->hasName($sportName)->find();

        $this->assertSame($sport->name, $result->name);
    }

    #[Test]
    public function ItReturnsNullIfSportNotFound(): void
    {
        $SportByName = new SportByName;

        $result = $SportByName->hasName('Non-existing Sport')->find();

        $this->assertNull($result);
    }
}
<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Sport\Queries\SportByName;
use App\Sport\Sport;
use App\Testing\RefreshDatabase;
use Database\Main\Factories\SportFactory;


final class SportByNameTest extends TestCase
{
    #[Test]
    public function ItCanGetASportByName(): void
    {
        $sportName = 'Football';

        $sport = SportFactory::new()->withName($sportName)->create();

        $SportByName = new SportByName;
        $result = $SportByName->find($sportName);

        $this->assertSame($sport->name, $result->name);
    }

    #[Test]
    public function ItReturnsNullIfSportNotFound(): void
    {
        $SportByName = new SportByName;

        $result = $SportByName->find('Non-existing Sport');

        $this->assertNull($result);
    }

    #[Test] 
    public function ItCanCreateInstanceofSport(): void
    {
        $sportName = 'Football';
        $SportByName = new SportByName;

        $sport = SportFactory::new()->withName($sportName)->create();

        $result = $SportByName->find($sportName);
        
        $this->assertInstanceOf(Sport::class, $result);
    }
}
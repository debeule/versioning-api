<?php

declare(strict_types=1);

namespace App\Sport\Queries;

use App\Testing\TestCase;
use App\Sport\Queries\SportByName;
use App\Sport\Sport;
use App\Testing\RefreshDatabase;
use Database\Main\Factories\SportFactory;


final class SportByNameTest extends TestCase
{
    /**
     * @test
     */
    public function ItCanGetASportByName(): void
    {
        $sportName = 'Football';

        $sport = SportFactory::new()->withName($sportName)->create();

        $SportByName = new SportByName;
        $result = $SportByName->get($sportName);

        $this->assertSame($sport->name, $result->name);
    }

    /**
     * @test
     */
    public function ItReturnsNullIfSportNotFound(): void
    {
        $SportByName = new SportByName;

        $this->assertNull($SportByName->find('Non-existing Sport'));
    }

    /**
     * @test
     */ 
    public function ItCanCreateInstanceofSport(): void
    {
        $sportName = 'Football';
        $SportByName = new SportByName;

        $sport = SportFactory::new()->withName($sportName)->create();
        
        $this->assertInstanceOf(Sport::class, $SportByName->get($sportName));
    }
}
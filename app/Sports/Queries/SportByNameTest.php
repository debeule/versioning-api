<?php

declare(strict_types=1);

namespace App\Sports\Queries;

use App\Testing\TestCase;
use App\Sports\Queries\SportByName;
use App\Sports\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\SportFactory;


final class SportByNameTest extends TestCase
{
    $connection = 'sqlite';

    use RefreshDatabase;

    /** @test */
    public function ItCanGetASportByName()
    {
        $sportName = 'Football';

        $sport = SportFactory::new()->withName($sportName)->create();
        
        $SportByName = new SportByName;
        $result = $SportByName($sportName);

        $sport->delete();

        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertEquals($sport->name, $result->name);
        $this->assertSoftDeleted($sport);
    }

    /** @test */
    public function ItReturnsNullIfSportNotFound()
    {
        $SportByName = new SportByName();

        $this->assertNull($SportByName('Non-existing Sport'));
    }
}
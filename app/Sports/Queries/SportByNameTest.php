<?php

declare(strict_types=1);

namespace App\Sports\Queries;

use App\Testing\TestCase;
use App\Sports\Queries\GetSportByNameQuery;
use App\Sports\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Factories\SportFactory;


final class SportByNameQueryTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function ItCanGetASportByName()
    {
        $sportName = 'Football';

        $sport = SportFactory::new()->withName($sportName)->create();
        
        $GetSportByNameQuery = new GetSportByNameQuery;
        $result = $GetSportByNameQuery($sportName);

        $sport->delete();

        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertEquals($sport->name, $result->name);
        $this->assertSoftDeleted($sport);
    }

    /** @test */
    public function ItReturnsNullIfSportNotFound()
    {
        $GetSportByNameQuery = new GetSportByNameQuery();

        $this->assertNull($GetSportByNameQuery('Non-existing Sport'));
    }
}
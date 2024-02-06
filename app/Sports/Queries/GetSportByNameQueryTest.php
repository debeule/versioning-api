<?php

namespace App\Sports\Queries;

use Testing\TestCase;
use App\Sports\GetSportByNameQuery;
use App\Sports\Sport;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetSportByNameQueryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_get_a_sport_by_name()
    {
        $sport = Sport::factory()->create(['name' => 'Football']);

        $query = new GetSportByNameQuery('Football');

        $result = $query->handle();

        $this->assertInstanceOf(Sport::class, $result);
        $this->assertEquals($sport->name, $result->name);
    }

    /** @test */
    public function it_returns_null_if_sport_not_found()
    {
        $query = new GetSportByNameQuery('Non-existing Sport');

        $result = $query->handle();

        $this->assertNull($result);
    }
}
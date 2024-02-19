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
    protected $connectionsToTransact = ['db-testing'];
    
    use RefreshDatabase;

    /** @test */
    public function ItCanGetASportByName()
    {
        $sportName = 'Football';

        $sport = SportFactory::new()->withName($sportName)->create();
        
        $SportByName = new SportByName;
        $result = $SportByName->get($sportName);

        $sport->delete();

        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertEquals($sport->name, $result->name);
        $this->assertSoftDeleted($sport);
    }

    /** @test */
    public function ItReturnsNullIfSportNotFound()
    {
        $SportByName = new SportByName;

        $this->assertNull($SportByName->find('Non-existing Sport'));
    }
}
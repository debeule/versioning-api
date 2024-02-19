<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Testing\TestCase;
use App\Sport\Sport;
use App\Kohera\Sport as KoheraSport;
use App\Testing\RefreshDatabase;
use App\Sport\Commands\CreateSport;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateSportTest extends TestCase
{
    use RefreshDatabase, DispatchesJobs;
    
    /** @test */
    public function itCanCreateASportFromkoheraSport()
    {
        $koheraSport = KoheraSport::factory()->create();

        $sportCreated = $this->dispatchSync(new CreateSport($koheraSport));
        
        $sport = Sport::where('name', $koheraSport->Sportkeuze)->first();
        
        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);
        $this->assertTrue($sportCreated);
    }
}
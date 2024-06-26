<?php

declare(strict_types=1);

namespace App\Sport\Commands;

use App\Kohera\Sport as KoheraSport;
use App\Sport\Sport;
use App\Testing\TestCase;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use PHPUnit\Framework\Attributes\Test;


final class CreateSportTest extends TestCase
{

    #[Test]
    public function itCanCreateSportFromKoheraSport(): void
    {
        $koheraSport = KoheraSportFactory::new()->create();

        $this->dispatchSync(new CreateSport($koheraSport));
        
        $sport = Sport::where('record_id', $koheraSport->recordId())->first();
        
        $this->assertInstanceOf(koheraSport::class, $koheraSport);
        $this->assertInstanceOf(Sport::class, $sport);

        $this->assertEquals($koheraSport->name(), $sport->name);
    }
}
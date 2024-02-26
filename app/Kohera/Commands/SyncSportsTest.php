<?php

declare(strict_types=1);

namespace App\Kohera\Commands;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Sport\Sport;
use App\Kohera\Sport as KoheraSport;
use Database\Kohera\Factories\SportFactory as KoheraSportFactory;
use App\Kohera\Commands\SyncSports;

final class SyncSportsTest extends TestCase
{
    #[Test]
    public function itDispatchesCreateSportsWhenNotExists(): void
    {
        KoheraSportFactory::new()->count(3)->create();
        $syncSports = new SyncSports();
        $syncSports();

        KoheraSportFactory::new()->count(3)->create();

        $existingSports = Sport::get();
        $koheraSports = KoheraSport::get();

        $this->assertGreaterThan($existingSports->count(), $koheraSports->count());

        $syncSports = new SyncSports();
        $syncSports();

        $existingSports = Sport::get();
        $koheraSports = KoheraSport::get();
        $this->assertEquals($existingSports->count(), $koheraSports->count());
    }

    #[Test]
    public function itSoftDeletesDeletedRecords(): void
    {
        KoheraSportFactory::new()->count(3)->create();
        $syncSports = new SyncSports();
        $syncSports();

        $koheraSport = KoheraSport::first();
        $koheraSportName = $koheraSport->name();
        $koheraSport->delete();

        $syncSports = new SyncSports();
        $syncSports();
            
        $this->assertSoftDeleted(Sport::where('name', $koheraSportName)->first());

        $existingSports = Sport::get();
        $koheraSports = KoheraSport::get();

        $this->assertGreaterThan($koheraSports->count(), $existingSports->count());
    }
}
<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use App\Imports\SyncAllDomains;
use Illuminate\Support\Facades\Queue;

final class SyncHandlerTest extends TestCase
{
    #[Test]
    public function itDispatchesSyncAllDomains(): void
    {
        Queue::fake();

        $syncHandler = new SyncHandler;
        $syncHandler();

        Queue::assertPushed(SyncAllDomains::class);
    }

}
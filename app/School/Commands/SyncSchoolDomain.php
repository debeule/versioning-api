<?php

declare(strict_types=1);

namespace App\School\Commands;

use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncSchoolDomain
{
    use DispatchesJobs;

    public function __invoke(): void
    {
        $this->DispatchSync(new SyncAddresses);

        $this->DispatchSync(new SyncSchools);

        $this->DispatchSync(new SyncBillingProfiles);
    }
}
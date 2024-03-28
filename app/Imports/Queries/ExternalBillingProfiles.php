<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use Illuminate\Support\Collection;

interface ExternalBillingProfiles
{
    public function get(): Collection;
}

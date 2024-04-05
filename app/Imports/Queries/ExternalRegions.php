<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use Illuminate\Support\Collection;

interface ExternalRegions
{
    public function get(): Collection;
    public function getWithDoubles(): Collection;
}

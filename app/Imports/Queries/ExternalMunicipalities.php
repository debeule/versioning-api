<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\Municipalities\MunicipalityContract;
use Illuminate\Support\Collection;

interface ExternalMunicipalities
{
    public function get(): Collection;
}

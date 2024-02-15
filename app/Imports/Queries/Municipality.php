<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\School\Region;

interface Municipality
{
    public function name(): string;
    public function postalCode(): string;

    public function region(): Region;
}
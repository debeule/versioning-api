<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\Location\Region;

interface Municipality
{
    public function name(): string;
    public function province(): string;
    public function postalCode(): int;
    public function headMunicipality(): ?string;
}
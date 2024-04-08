<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\Location\Municipality as DbMunicipality;

interface Municipality
{
    public function recordId(): string;
    public function name(): string;
    public function province(): string;
    public function postalCode(): int;
    public function headMunicipality(): ?string;
    
    public function hasChanged(DbMunicipality $dbMunicipality): bool;
}
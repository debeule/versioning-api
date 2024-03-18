<?php

declare(strict_types=1);

namespace App\Imports\Queries;


interface Municipality
{
    public function name(): string;
    public function province(): string;
    public function postalCode(): int;
    public function headMunicipality(): ?string;
}
<?php

declare(strict_types=1);

namespace App\Imports\Queries;

interface Region
{
    public function recordId(): int;
    public function name(): string;
    public function regionNumber(): int;
    public function postalCode(): int;
    
    public function hasChanged(): bool;
}
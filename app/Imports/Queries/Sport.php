<?php

declare(strict_types=1);

namespace App\Imports\Queries;

interface Sport
{
    public function recordId(): int;
    public function name(): string;
    
    public function hasChanged(): bool;
}
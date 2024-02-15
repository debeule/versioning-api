<?php

declare(strict_types=1);

namespace App\Imports\Queries;

interface Sport
{
    public function sportId(): int;
    public function name(): string;
}
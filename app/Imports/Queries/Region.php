<?php

declare(strict_types=1);

namespace App\Imports\Queries;

interface Region
{
    public function name(): string;
    public function regionId(): int;
    public function province(): string;
}
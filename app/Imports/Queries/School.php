<?php

declare(strict_types=1);

namespace App\Imports\Queries;

use App\School\Address;

interface School
{
    public function sourceId(): string;
    public function name(): string;
    public function email(): ?string;
    public function contactEmail(): ?string;
    public function type(): string;
    public function schoolNumber(): string;
    public function institutionId(): int;
    public function studentCount(): int;

    public function address(): Address;
}
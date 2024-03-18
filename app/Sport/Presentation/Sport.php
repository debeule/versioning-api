<?php

declare(strict_types=1);

namespace App\Sport\Presentation;

use App\Sport\Sport as DbSport;

final class Sport
{
    public static function new(): self
    {
        return new self();
    }

    public function build(DbSport $dbSport): self
    {
        $this->addSportAttributes($dbSport);

        return $this;
    }

    public function addSportAttributes(DbSport $dbSport): void
    {
        $this->name = $dbSport->name;
    }
}
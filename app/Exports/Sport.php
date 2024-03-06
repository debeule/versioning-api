<?php

declare(strict_types=1);

namespace App\Exports;

use App\Sport\Sport as DbSport;
use Illuminate\Database\Eloquent\Model;

final class Sport extends Model
{
    protected $fillable = [
        'name',
    ];

    public static function build(?DbSport $dbSport): ?self
    {
        if(is_null($dbSport)) return null;

        $sport = new self();

        $sport->addSportAttributes($dbSport);

        return $sport;
    }

    public function addSportAttributes(DbSport $dbSport): void
    {
        $this->name = $dbSport->name;
    }
}
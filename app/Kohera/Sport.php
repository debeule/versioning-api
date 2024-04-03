<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Imports\Queries\Sport as SportContract;
use App\Imports\Sanitizer\Sanitizer;
use Illuminate\Database\Eloquent\Model;
use App\Sport\Sport as DbSport;

final class Sport extends Model implements SportContract
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

    protected $fillable = [
        'Sportkeuze',
        'BK_SportTakSportOrganisatie',
        'Sport',
        'Hoofdsport',
    ];

    public function recordId(): int
    {
        return Sanitizer::input($this->id)->numericValue();
    }

    public function name(): string
    {
        return Sanitizer::input($this->Sportkeuze)->stringToLower()->value();
    }

    public function hasChanged(DbSport $dbSport): bool
    {
        return $dbSport->name !== $this->name();
    }
}
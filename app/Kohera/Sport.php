<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\Sport as SportContract;
use App\Imports\Sanitizer\Sanitizer;

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

    public function sportId(): int
    {
        return Sanitizer::input($this->id)->intValue();
    }

    public function name(): string
    {
        return Sanitizer::input($this->Sportkeuze)->stringToLower()->value();
    }
}
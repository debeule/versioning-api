<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\Sport as SportContract;

final class Sport extends Model implements SportContract
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

    use HasFactory;
    
    protected static function newFactory()
    {
        return \Database\Kohera\Factories\SportFactory::new();
    }

    protected $fillable = [
        'Sportkeuze',
        'BK_SportTakSportOrganisatie',
        'Sport',
        'Hoofdsport',
    ];

    public function sportId(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->Sportkeuze;
    }
}
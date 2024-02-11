<?php 

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Kohera\DwhSport;
use App\Sports\Sport;


final class CreateNewSportCommand
{
    public function __invoke(DwhSport $dwhSport): bool
    {
        $newSport = new Sport();

        $newSport->name = $dwhSport->Sportkeuze;

        return $newSport->save();
    }
}
<?php 

declare(strict_types=1);

namespace App\Sports\Commands;

use App\Kohera\Sport as KoheraSport;
use App\Sports\Sport;


final class CreateSport
{
    public function __invoke(KoheraSport $koheraSport): bool
    {
        $newSport = new Sport();

        $newSport->name = $koheraSport->Sportkeuze;

        return $newSport->save();
    }
}
<?php

declare(strict_types=1);

namespace Database\Bpost\Factories;

use App\Bpost\Municipality;
use App\Imports\Values\ProvinceGroup;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Collection;

final class MunicipalityFactory
{
    public function __construct(
        private ?Municipality $municipality,
    ){}

    public static function new()
    {
        $faker = FakerFactory::create();

        return new self(new Municipality([
            $faker->randomNumber(4),
            $faker->city,
            $faker->city,
            'Ja',
            $faker->randomElement(ProvinceGroup::allProvinces()->get()),
        ]));
    }

    public function count(int $times, bool $toArray = false): mixed
    {
        $grouping = $toArray ? [] : collect();

        for ($i = 0; $i < $times; $i++) 
        {
            if (!$toArray) $grouping->push(MunicipalityFactory::new()->make());

            if ($toArray) array_push($grouping, MunicipalityFactory::new()->makeArray());
        }

        return $grouping;
    }
    
    public function make(): Municipality
    {
        return $this->municipality;
    }

    public function makeArray(): array
    {
        return array_values(collect($this->municipality)->toArray());
    }
}

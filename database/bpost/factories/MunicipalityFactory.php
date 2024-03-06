<?php

declare(strict_types=1);

namespace Database\Bpost\Factories;

use App\Bpost\Municipality;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MunicipalityFactory extends Factory
{
    protected $model = Municipality::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Postcode' => $this->faker->randomNumber(4),
            'Plaatsnaam' => $this->faker->city,
            'Deelgemeente' => $this->faker->randomElement(['Ja', 'Nee']),
            'Hoofdgemeente' => $this->faker->city,
            'Provincie' => $this->faker->randomElement(['Antwerpen', 'Limburg', 'Oost-Vlaanderen', 'Vlaams-Brabant', 'West-Vlaanderen']),
        ];
    }

    public function withoutHeadMunicipality(): self
    {
        return $this->state(['
            Deelgemeente' => 'Nee',
            'HoofdGemeente' => null,
        ]);
    }
}

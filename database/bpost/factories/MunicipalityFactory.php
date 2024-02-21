<?php

declare(strict_types=1);

namespace Database\Bpost\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Bpost\Municipality;

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
            'Postcode' => 2000,
            'Plaatsnaam' => 'Beerse',
            'Deelgemeente' => 'Ja',
            'Hoofdgemeente' => 'Vlimmeren',
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

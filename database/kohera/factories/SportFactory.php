<?php

declare(strict_types=1);

namespace Database\Kohera\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Kohera\Sport;

final class SportFactory extends Factory
{
    protected $model = Sport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Sportkeuze' => $this->faker->name(),
            'BK_SportTakSportOrganisatie' => $this->faker->company(),
            'Sport' => $this->faker->name(),
            'Hoofdsport' => $this->faker->name(),
        ];
    }
}

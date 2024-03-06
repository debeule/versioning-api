<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use App\Sport\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->name(),
            'sport_id' => $this->faker->unique()->randomNumber(),
        ];
    }

    public function withName(string $name): self
    {
        return $this->state(['name' => $name]);
    }
}

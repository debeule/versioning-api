<?php

declare(strict_types=1);

namespace Database\Kohera\Factories;

use App\Kohera\School;
use Illuminate\Database\Eloquent\Factories\Factory;

final class SchoolFactory extends Factory
{
    protected $model = School::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'Place_id' => $this->faker->randomNumber(3),
            'Name' => $this->faker->name(),
            'Gangmaker_mail' => $this->faker->email(),
            'School_mail' => $this->faker->email(),
            'address' => $this->faker->firstName() . " " . $this->faker->numberBetween(1, 1000),
            'Student_Count' => $this->faker->numberBetween(1, 100),
            'School_Id' => $this->faker->randomNumber(5),
            'Instellingsnummer' => $this->faker->randomNumber(8),
            'Postcode' => 2000,
            'Gemeente' => "beerse",
            'Type' => $this->faker->randomElement(['ko', 'lo', 'so']),
            'Facturatie_Naam' => $this->faker->company(),
            'Facturatie_tav' => $this->faker->name(),
            'Facturatie_Adres' => $this->faker->firstName() . " " . $this->faker->numberBetween(1, 1000),
            'Facturatie_Postcode' => 2000,
            'Facturatie_Gemeente' => "beerse",
            'BTWNummer' => $this->faker->randomNumber(8),
            'Facturatie_Email' => $this->faker->email(),
        ];
    }
}

<?php

declare(strict_types=1);

namespace Database\Factories\Kohera;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Kohera\School;

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
            'Place_id' => $this->faker->randomNumber(8),
            'Name' => $this->faker->name(),
            'Gangmaker_mail' => $this->faker->email(),
            'School_mail' => $this->faker->email(),
            'address' => $this->faker->address(),
            'Student_Count' => $this->faker->numberBetween(1, 100),
            'School_Id' => $this->faker->randomNumber(5),
            'Instellingsnummer' => $this->faker->randomNumber(8),
            'Postcode' => $this->faker->numberBetween(1000, 4000),
            'Gemeente' => $this->faker->city(),
            'Type' => $this->faker->randomElement(['KO', 'LO', 'SO']),
            'Facturatie_Naam' => $this->faker->company(),
            'Facturatie_tav' => $this->faker->name(),
            'Facturatie_Adres' => $this->faker->address(),
            'Facturatie_Postcode' => $this->faker->postcode(),
            'Facturatie_Gemeente' => $this->faker->city(),
            'BTWNummer' => $this->faker->randomNumber(8),
            'Facturatie_Email' => $this->faker->email(),
        ];
    }
}

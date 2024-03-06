<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use App\School\School;
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
            'school_id' => $this->faker->randomNumber(3),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'contact_email' => $this->faker->email(),
            'type' => $this->faker->randomElement(['ko', 'lo', 'so']),
            'school_number' => $this->faker->randomNumber(5),
            'institution_id' => $this->faker->randomNumber(5),
            'student_count' => $this->faker->numberBetween(1, 100),
            'address_id' => AddressFactory::new()->create()->id,
        ];
    }

    public function withId(string $idString): self
    {
        return $this->state(['school_id' => $idString]);
    }
}

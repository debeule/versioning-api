<?php

declare(strict_types=1);

namespace Database\Main\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\School\BillingProfile;

final class BillingProfileFactory extends Factory
{
    protected $model = BillingProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'billing_profile_id' => $this->faker->unique()->randomNumber(5),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'tav' => $this->faker->name(),
            'vat_number' => (string) $this->faker->unique()->randomNumber(5),
            'address_id' => AddressFactory::new()->create()->id,
            'school_id' => SchoolFactory::new()->create()->id,
        ];
    }

    public function withSchoolId(int $id): self
    {
        return $this->state(['school_id' => $id]);
    }
}

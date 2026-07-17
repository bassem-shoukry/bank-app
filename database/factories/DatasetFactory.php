<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\CaseType;
use App\Models\Dataset;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dataset>
 */
class DatasetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'national_id' => $this->faker->numerify('##############'),
            'address' => $this->faker->address(),
            'case_number' => (string) $this->faker->unique()->numberBetween(1000, 999999),
            'case_type_id' => CaseType::factory(),
            'verdict' => $this->faker->sentence(10),
            'payment_status' => $this->faker->randomElement(PaymentStatus::cases()),
            'user_id' => User::factory(),
        ];
    }
}

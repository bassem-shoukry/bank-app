<?php

namespace Database\Factories;

use App\Models\CaseType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CaseType>
 */
class CaseTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'نوع '.fake()->unique()->numberBetween(1, 1000000),
        ];
    }
}

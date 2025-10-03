<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Development>
 */
class DevelopmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(640, 480, 'business', true),
            'name' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'person_in_charge' => $this->faker->name,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'amount' => $this->faker->numberBetween(1000, 100000),
            'status' => $this->faker->randomElement(['ongoing', 'completed']),
        ];
    }
}

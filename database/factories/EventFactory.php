<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'thumbnail' => $this->faker->imageUrl(640, 480, 'events', true),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}

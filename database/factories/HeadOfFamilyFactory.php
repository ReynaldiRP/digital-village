<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HeadOfFamily>
 */
class HeadOfFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::pluck('id')->random(),
            'profile_picture' => $this->faker->imageUrl(),
            'identify_number' => $this->faker->unique()->numerify('##########'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'phone_number' => $this->faker->phoneNumber(),
            'occupation' => $this->faker->jobTitle(),
            'marital_status' => $this->faker->randomElement(['single', 'married']),
        ];
    }
}

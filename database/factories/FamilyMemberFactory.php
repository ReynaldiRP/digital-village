<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FamilyMember>
 */
class FamilyMemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $headOfFamilyIds = \App\Models\HeadOfFamily::pluck('id')->toArray();
        $userIds = \App\Models\User::pluck('id')->toArray();

        return [
            'head_of_family_id' => $this->faker->randomElement($headOfFamilyIds),
            'user_id' => $this->faker->randomElement($userIds),
            'profile_picture' => $this->faker->imageUrl(640, 480, 'people', true),
            'identify_number' => $this->faker->unique()->numerify('##########'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->date(),
            'phone_number' => $this->faker->phoneNumber(),
            'occupation' => $this->faker->jobTitle(),
            'marital_status' => $this->faker->randomElement(['single', 'married']),
            'relation' => $this->faker->randomElement(['child', 'wife', 'husband'])
        ];
    }
}

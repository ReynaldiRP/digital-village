<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistanceRecipient>
 */
class SocialAssistanceRecipientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $socialAssistanceIds = \App\Models\SocialAssistance::pluck('id')->toArray();
        $headOfFamilyIds = \App\Models\HeadOfFamily::pluck('id')->toArray();

        return [
            'social_assistance_id' => $this->faker->randomElement($socialAssistanceIds),
            'head_of_family_id' => $this->faker->randomElement($headOfFamilyIds),
            'amount' => $this->faker->numberBetween(100000, 1000000),
            'reason' => $this->faker->sentence(),
            'bank' => $this->faker->randomElement(['BRI', 'BNI', 'BCA', 'Mandiri']),
            'account_number' => $this->faker->numerify('##########'),
            'proof' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected'])
        ];
    }
}

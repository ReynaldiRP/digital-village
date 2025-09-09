<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialAssistance>
 */
class SocialAssistanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $provider = $this->faker->company();

        return [
            'thumbnail' => $this->faker->imageUrl(640, 480, 'people', true),
            'name' => $this->faker->randomElement([
                'Bantuan Langsung Tunai (BLT)',
                'Bantuan Pangan Non-Tunai (BPNT)',
                'Subsidi Listrik',
                'Subsidi BBM',
                'Kartu Indonesia Sehat (KIS)',
                'Kartu Indonesia Pintar (KIP)',
                'Bantuan Sosial Tunai (BST)',
                'Program Keluarga Harapan (PKH)',
            ]) . ' ' . $provider,
            'category' => $this->faker->randomElement(['cash', 'staple', 'subsidized', 'fuel', 'health']),
            'amount' => $this->faker->randomFloat(2, 100000, 1000000),
            'provider' => $provider,
            'description' => $this->faker->paragraph(),
            'is_available' => $this->faker->boolean(80),
        ];
    }
}

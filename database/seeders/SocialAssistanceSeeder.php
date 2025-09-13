<?php

namespace Database\Seeders;

use App\Models\HeadOfFamily;
use Database\Factories\SocialAssistanceFactory;
use Database\Factories\SocialAssistanceRecipientFactory;
use Illuminate\Database\Seeder;

class SocialAssistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $headOfFamily = HeadOfFamily::pluck('id')->toArray();

        SocialAssistanceFactory::new()->count(5)->create()->each(function ($socialAssistance) use ($headOfFamily) {
            SocialAssistanceRecipientFactory::new()->count(10)->create([
                'social_assistance_id' => $socialAssistance->id,
                'head_of_family_id' => $headOfFamily[array_rand($headOfFamily)],
            ]);
        });
    }
}

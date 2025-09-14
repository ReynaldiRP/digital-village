<?php

namespace Database\Seeders;

use Database\Factories\SocialAssistanceRecipientFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialAssistanceRecipientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SocialAssistanceRecipientFactory::new()->count(10)->create();
    }
}

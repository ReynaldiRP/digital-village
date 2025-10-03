<?php

namespace Database\Seeders;

use App\Models\DevelopmentApplicant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevelopmentApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DevelopmentApplicant::factory()->count(20)->create();
    }
}

<?php

namespace Database\Seeders;

use Database\Factories\HeadOfFamilyFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadOfFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeadOfFamilyFactory::new()->count(10)->create();
    }
}

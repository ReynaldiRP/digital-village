<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use Database\Factories\FamilyMemberFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FamilyMemberFactory::new()->count(15)->create();
    }
}

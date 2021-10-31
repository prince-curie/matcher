<?php

namespace Database\Seeders;

use App\Models\SearchProfile;
use Illuminate\Database\Seeder;

class SearchProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SearchProfile::factory()
            ->count(500)
            ->create();
    }
}

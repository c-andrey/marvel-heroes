<?php

namespace Database\Seeders;

use App\Models\Votes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Votes::insert([
            [
                'hero_id' => 1011334,
                'votes' => 1,
            ],
            [
                'hero_id' => 1,
                'votes' => 1,
            ],
            [
                'hero_id' => 2,
                'votes' => 3,
            ],
            [
                'hero_id' => 4,
                'votes' => 4,
            ]
        ]);
    }
}

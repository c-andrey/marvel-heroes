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
        Votes::create([
            'hero_id' => 1011334,
            'votes' => 1
        ]);
    }
}

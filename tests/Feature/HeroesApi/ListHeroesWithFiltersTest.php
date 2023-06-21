<?php

namespace Tests\Feature\HeroesApi;

use App\Models\Votes;
use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListHeroesWithFiltersTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed(VotesSeeder::class);
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'heroes.results');
        $response->assertJson([
            "heroes" => [
                "results" => [[
                    "name" => "3-D Man",

                ]]
            ]
        ]);
    }
}

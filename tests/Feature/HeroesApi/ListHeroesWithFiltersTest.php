<?php

namespace Tests\Feature\HeroesApi;

use App\Models\Votes;
use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
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
        $name = "3-D Man";
        $limit = 1;

        $url = config('MARVEL_API_URL') . '/characters' . '?name=' . $name . '&limit=' . $limit . '*';

        Http::fake([
            $url => Http::response([
                'data' => [
                    "offset" =>  0,
                    "limit" =>  1,
                    "total" =>  1,
                    "count" =>  1,
                    "results" =>  [
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->get('/api/heroes' . '?name=' . $name . '&limit=' . $limit . '*');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'heroes.results');
        $response->assertJson([
            "heroes" => [
                "limit" => 1,
                "total" => 1,
                "results" => [[
                    "name" => "3-D Man",

                ]]
            ]
        ]);
    }
}

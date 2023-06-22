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
     * Filter results passing name and limit.
     */
    public function test_list_heroes_with_filters(): void
    {
        $this->seed(VotesSeeder::class);
        $name = "3-D Man";
        $limit = 5;

        $url = config('MARVEL_API_URL') . '/characters' . '?name=' . $name . '&limit=' . $limit . '*';

        Http::fake([
            $url => Http::response([
                'data' => [
                    "offset" =>  0,
                    "limit" =>  $limit,
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

        $response = $this->get('/api/heroes' . '?name=' . $name . '&perPage=' . $limit . '&page=1');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'heroes.results');
        $response->assertJson([
            "heroes" => [
                "limit" => $limit,
                "results" => [[
                    "name" => "3-D Man",

                ]]
            ]
        ]);
    }
}

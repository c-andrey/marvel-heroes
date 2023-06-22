<?php

namespace Tests\Feature\HeroesApi;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListHeroesOrderedByVotesQuantityTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test to list heroes ordered by votes quantity.
     */
    public function test_list_heroes_ordered_by_votes_quantity(): void
    {
        $this->seed(VotesSeeder::class);

        $page = 2;
        $perPage = 5;
        $offset = ($page - 1) * $perPage;
        $url = config('MARVEL_API_URL') . '/characters*';
        Http::fake([
            $url => Http::response([
                'data' => [
                    "offset" =>  $offset,
                    "limit" =>  5,
                    "total" =>  10,
                    "count" =>  5,
                    "page" => 2,
                    "pages" => 2,
                    "results" =>  [
                        [
                            "id" =>  1,
                            "name" =>  "3-D Man"
                        ],
                        [
                            "id" =>  2,
                            "name" =>  "3-D Man"
                        ],
                        [
                            "id" =>  4,
                            "name" =>  "3-D Man"
                        ]
                    ]
                ]
            ], 200)
        ]);


        $response = $this->get('/api/heroes' . '?page=' . $page . '&perPage=' . $perPage);

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'heroes.results');
        $response->assertJson(function ($json) {
            $json->has('heroes.results', 3)
                ->where('heroes.results.0.id', 4)
                ->where('heroes.results.1.id', 2)
                ->where('heroes.results.2.id', 1);
        });
    }
}

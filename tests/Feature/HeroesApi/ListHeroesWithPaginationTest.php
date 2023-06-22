<?php

namespace Tests\Feature\HeroesApi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListHeroesWithPaginationTest extends TestCase
{
    /**
     * Basic pagination test on heroes api.
     */
    public function test_list_heroes_with_pagination(): void
    {
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
                    "pages" => 2,
                    "results" =>  [
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ],
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ],
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ],
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ],
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ]
                    ]
                ]
            ], 200)
        ]);


        $response = $this->get('/api/heroes' . '?page=' . $page . '&perPage=' . $perPage);

        $response->assertStatus(200);
        $response->assertJsonCount(5, 'heroes.results');
        $response->assertJson([
            'heroes' => [
                'offset' => 5,
                'page' => 2,
                "pages" => 2,
            ]
        ]);
    }
}

<?php

namespace Tests\Feature\HeroesApi;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ListHeroesApiWithVotesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed(VotesSeeder::class);

        $url = config('MARVEL_API_URL') . '/characters*';

        Http::fake([
            $url => Http::response([
                'data' => [
                    "offset" =>  0,
                    "limit" =>  5,
                    "total" =>  1562,
                    "count" =>  5,
                    "results" =>  [
                        [
                            "id" =>  1011334,
                            "name" =>  "3-D Man"
                        ]
                    ]
                ]
            ], 200)
        ]);

        $response = $this->get('/api/heroes');

        $response->assertStatus(200);
        $response->assertJson([
            "heroes" => [
                "results" => [[
                    "id" => 1011334,
                    "votes" => 1,
                    "name" => "3-D Man"
                ]]
            ]
        ]);
    }
}

<?php

namespace Tests\Feature\HeroesApi;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CantConnectToMarvelApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_cant_connect_to_marvel_api(): void
    {
        $name = "3-D Man";
        $limit = 5;

        $url = config('MARVEL_API_URL') . '/characters*';

        Http::fake([
            $url => Http::response([
                'data' => [
                    'error' => 'Error getting heroes from Marvel API'
                ]
            ], 500)
        ]);

        $response = $this->get('/api/heroes' . '?name=' . $name . '&perPage=' . $limit . '&page=1');

        $response->assertStatus(500);
        $response->assertJson(['error' => 'Error getting heroes from Marvel API']);
    }
}

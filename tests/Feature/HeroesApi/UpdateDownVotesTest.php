<?php

namespace Tests\Feature\HeroesApi;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateDownVotesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test to update down the votes on a hero.
     */
    public function test_update_down_votes(): void
    {
        $this->seed(VotesSeeder::class);

        $response = $this->post('/api/heroes/vote', [
            'hero_id' => 1011334,
            'action' => 'down'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['voted' => true]);
        $this->assertDatabaseHas('votes', [
            'hero_id' => 1011334,
            'votes' => 0
        ]);
    }
}

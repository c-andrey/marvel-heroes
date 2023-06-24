<?php

namespace Tests\Feature\HeroesApi;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WrongActionVoteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_send_wrong_action_vote(): void
    {
        $this->seed(VotesSeeder::class);

        $response = $this->post('/api/heroes/vote', [
            'hero_id' => 1011334,
            'action' => 'any_action'
        ]);

        $response->assertStatus(400);
        $response->assertJson(['voted' => false, 'error' => 'Invalid action']);
        $this->assertDatabaseMissing('votes', [
            'hero_id' => 1011334,
            'votes' => 2
        ]);
    }
}

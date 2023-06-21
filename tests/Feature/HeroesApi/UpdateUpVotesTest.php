<?php

namespace Tests\Feature;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateUpVotesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A test to update votes.
     */
    public function test_update_votes(): void
    {
        $this->seed(VotesSeeder::class);

        $response = $this->post('/api/vote', [
            'hero_id' => 1011334,
            'action' => 'up'
        ]);

        $response->assertStatus(200);
        $response->assertJson(['voted' => true]);
        $this->assertDatabaseHas('votes', [
            'hero_id' => 1011334,
            'votes' => 2
        ]);
    }
}

<?php

namespace Tests\Feature;

use Database\Seeders\VotesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateDownVotesTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->seed(VotesSeeder::class);

        $response = $this->post('/api/vote', [
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

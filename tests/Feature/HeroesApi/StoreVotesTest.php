<?php

namespace Tests\Feature;

use App\Models\Votes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreVotesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test for create votes.
     */
    public function test_create_votes(): void
    {
        $response = $this->post('/api/vote', [
            'hero_id' => 1,
            'action' => 'up'
        ]);


        $response->assertStatus(200);
        $response->assertJson(['voted' => true]);
        $this->assertDatabaseHas('votes', [
            'hero_id' => 1,
            'votes' => 1
        ]);
        $this->assertDatabaseCount('votes', 1);
    }
}

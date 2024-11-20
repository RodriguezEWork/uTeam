<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_movie()
    {
        $response = $this->postJson('/api/movies', [
            'title' => 'Inception',
            'genre' => 1,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('movies', ['title' => 'Inception']);
    }

    /** @test */
    public function it_can_update_a_movie()
    {
        $movie = Movie::factory()->create();

        $response = $this->putJson("/api/movies/{$movie->id}", [
            'title' => 'The Matrix',
            'genre' => 2,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('movies', ['title' => 'The Matrix']);
    }

    /** @test */
    public function it_can_delete_a_movie()
    {
        $movie = Movie::factory()->create();

        $response = $this->deleteJson("/api/movies/{$movie->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }
} 
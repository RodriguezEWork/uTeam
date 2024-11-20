<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        $response = $this->postJson('/api/users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'birthdate' => '1990-01-01',
            'has-insurance' => false,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    /** @test */
    public function it_can_list_users()
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_show_a_user_with_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson(['id' => $user->id]);
    }

    /** @test */
    public function it_can_show_a_user_with_name()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->first_name} {$user->last_name}");

        $response->assertStatus(200)
                 ->assertJson(['first_name' => $user->first_name, 'last_name' => $user->last_name]);
    }

    /** @test */
    public function it_can_update_a_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'jane@example.com',
            'password' => 'newpassword',
            'birthdate' => '1992-01-01',
            'has-insurance' => true,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
    }

    /** @test */
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_attach_a_movie_to_a_user()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();

        $response = $this->postJson("/api/users/{$user->id}/movies", [
            'movie_id' => $movie->id,
        ]);

        $response->assertStatus(200);
        $this->assertTrue($user->movies()->where('id', $movie->id)->exists());
    }

    /** @test */
    public function it_can_detach_a_movie_from_a_user()
    {
        $user = User::factory()->create();
        $movie = Movie::factory()->create();
        $user->movies()->attach($movie->id);

        $response = $this->deleteJson("/api/users/{$user->id}/movies", [
            'movie_id' => $movie->id,
        ]);

        $response->assertStatus(200);
        $this->assertFalse($user->movies()->where('id', $movie->id)->exists());
    }
} 
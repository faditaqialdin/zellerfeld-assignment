<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_logging_in_and_token_generation(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/v1/auth/token', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)->assertJsonStructure(['message', 'access_token']);
    }

    public function test_logging_in_with_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'password' => 'password123',
        ]);

        $response = $this->postJson('/api/v1/auth/token', [
            'email' => $user->email,
            'password' => 'wrongPassword',
        ]);

        $response->assertStatus(401)->assertJson(['message' => 'Invalid credentials']);
    }

    public function test_logging_out_authenticated_user(): void
    {
        $user = User::factory()->create();

        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->deleteJson('/api/v1/auth/token');

        $response->assertStatus(200)->assertJson(['message' => 'Logged out successfully']);
    }

    public function test_logging_out_unauthenticated_user(): void
    {
        $response = $this->deleteJson('/api/v1/auth/token');

        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
    }
}

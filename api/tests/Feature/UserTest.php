<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_specific_user(): void
    {
        $user = User::factory()->create();
        $authUser = User::factory()->create();
        $token = $authUser->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->getJson("/api/v1/users/{$user->id}");

        $response->assertOk()->assertJsonFragment(['email' => $user->email]);
    }

    public function test_not_show_non_existent_user(): void
    {
        $authUser = User::factory()->create();
        $token = $authUser->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->getJson('/api/v1/users/999');

        $response->assertNotFound()->assertJson(['message' => 'Endpoint not found.']);
    }

    public function test_not_show_user_for_unauthenticated_user(): void
    {
        $response = $this->getJson('/api/v1/users/1');

        $response->assertUnauthorized()->assertJson(['message' => 'Unauthenticated.']);
    }
}

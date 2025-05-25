<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_authenticated_user_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->getJson('/api/v1/profile');

        $response->assertOk()->assertJsonFragment(['email' => $user->email]);
    }

    public function test_not_show_unauthenticated_user_profile(): void
    {
        $response = $this->getJson('/api/v1/profile');

        $response->assertUnauthorized()->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_update_authenticated_user_profile(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->patchJson('/api/v1/profile', [
            'name' => 'Updated Name',
        ]);

        $response->assertOk()->assertJsonFragment(['name' => 'Updated Name']);
    }

    public function test_not_update_unauthenticated_user_profile(): void
    {
        $response = $this->patchJson('/api/v1/profile', [
            'name' => 'Updated Name',
        ]);

        $response->assertUnauthorized()->assertJson(['message' => 'Unauthenticated.']);
    }
}

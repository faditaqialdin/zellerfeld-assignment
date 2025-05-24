<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_all_posts_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        Post::factory()->count(5)->create(['user_id' => $user->id]);
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->getJson('/api/v1/posts');

        $response->assertOk()->assertJsonCount(5, 'data');
    }

    public function test_not_list_all_posts_for_unauthenticated_user(): void
    {
        $response = $this->getJson('/api/v1/posts');

        $response->assertUnauthorized()->assertJson(['message' => 'Unauthenticated.']);
    }
}

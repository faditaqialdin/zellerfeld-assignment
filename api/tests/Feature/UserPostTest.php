<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserPostTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_specific_user_posts_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->getJson("/api/v1/users/{$user->id}/posts");

        $response->assertOk()->assertJsonCount(3, 'data');
    }

    public function test_not_list_all_posts_for_unauthenticated_user(): void
    {
        $user = User::factory()->create();
        Post::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->getJson("/api/v1/users/{$user->id}/posts");

        $response->assertUnauthorized()->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_not_list_non_existent_user_posts_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->getJson('/api/v1/users/999/posts');

        $response->assertNotFound()->assertJson(['message' => 'Endpoint not found.']);
    }

    public function test_create_post_for_authenticated_user(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/v1/users/{$user->id}/posts", [
            'content' => 'My first post',
        ]);

        $response->assertCreated()->assertJsonFragment(['content' => 'My first post']);
    }

    public function test_create_post_with_invalid_data(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/v1/users/{$user->id}/posts", [
            'content' => '', // Empty content
        ]);

        $response->assertUnprocessable()->assertJsonStructure(['message', 'errors' => ['content']]);
    }

    public function test_create_post_for_another_user(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson('/api/v1/users/999/posts', [
            'content' => 'This should fail',
        ]);

        $response->assertNotFound()->assertJson(['message' => 'Endpoint not found.']);
    }

    public function test_create_post_with_missing_content(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/v1/users/{$user->id}/posts", []);

        $response->assertUnprocessable()->assertJsonStructure(['message', 'errors' => ['content']]);
    }

    public function test_create_post_with_long_content(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/v1/users/{$user->id}/posts", [
            'content' => str_repeat('A', 300),
        ]);

        $response->assertUnprocessable()->assertJsonStructure(['message', 'errors' => ['content']]);
    }

    public function test_create_post_with_special_characters(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/v1/users/{$user->id}/posts", [
            'content' => 'Hello, world! @#&*()',
        ]);

        $response->assertCreated()->assertJsonFragment(['content' => 'Hello, world! @#&*()']);
    }

    public function test_create_post_with_html_content(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('api-token')->plainTextToken;

        $response = $this->withToken($token)->postJson("/api/v1/users/{$user->id}/posts", [
            'content' => '<p>This is a post with HTML content</p>',
        ]);

        $response->assertCreated()->assertJsonFragment(['content' => '<p>This is a post with HTML content</p>']);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_new_user(): void
    {
        $response = $this->postJson('/api/v1/users', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'securePass123',
        ]);

        $response->assertCreated()->assertJsonStructure(['id', 'name', 'email', 'created_at']);
    }

    public function test_register_with_invalid_info(): void
    {
        $response = $this->postJson('/api/v1/users', [
            'name' => 'Jane Doe',
            'email' => 'jane',
            'password' => 'securePass123',
        ]);

        $response->assertClientError()->assertJsonStructure(['message', 'errors' => ['email']]);
    }
}

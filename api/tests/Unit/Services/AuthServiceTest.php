<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Repositories\Eloquent\UserEloquentRepository;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    public function test_create_token_success(): void
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'test@example.com', 'password' => 'secret'])
            ->andReturn(true);

        $user = Mockery::mock(User::class);
        $user->shouldReceive('createToken')
            ->once()
            ->with('api-token')
            ->andReturn((object)['plainTextToken' => 'mocked-token']);

        $userRepo = Mockery::mock(UserEloquentRepository::class);
        $userRepo->shouldReceive('getUserByEmail')
            ->once()
            ->with('test@example.com')
            ->andReturn($user);

        $authService = new AuthService($userRepo);

        $token = $authService->createToken('test@example.com', 'secret');

        $this->assertEquals('mocked-token', $token);
    }

    public function test_create_token_invalid_credentials_throws_exception(): void
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'invalid@example.com', 'password' => 'wrong'])
            ->andReturn(false);

        $userRepo = Mockery::mock(UserEloquentRepository::class);

        $authService = new AuthService($userRepo);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $authService->createToken('invalid@example.com', 'wrong');
    }

    public function test_revoke_current_token(): void
    {
        $accessToken = Mockery::mock();
        $accessToken->shouldReceive('delete')
            ->once();

        $user = Mockery::mock(User::class);
        $user->shouldReceive('currentAccessToken')
            ->once()
            ->andReturn($accessToken);

        $userRepo = Mockery::mock(UserEloquentRepository::class);
        $authService = new AuthService($userRepo);

        $authService->revokeCurrentToken($user);
    }
}

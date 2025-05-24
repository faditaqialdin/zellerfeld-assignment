<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Eloquent\UserEloquentRepository;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

readonly class AuthService
{
    public function __construct(private UserEloquentRepository $userEloquentRepository)
    {
    }

    public function createToken(string $email, string $password): string
    {
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw new RuntimeException('Invalid credentials');
        }
        $user = $this->userEloquentRepository->getUserByEmail($email);
        return $user->createToken('api-token')->plainTextToken;
    }

    public function revokeCurrentToken(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}

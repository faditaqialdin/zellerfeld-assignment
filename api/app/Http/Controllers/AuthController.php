<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use RuntimeException;

readonly class AuthController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->createToken(
                $request->input('email'),
                $request->input('password')
            );
            return response()->json([
                'access_token' => $token,
            ]);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    public function logout(LogoutRequest $request): JsonResponse
    {
        $this->authService->revokeCurrentToken($request->user());
        return response()->json(['message' => 'Logged out']);
    }
}

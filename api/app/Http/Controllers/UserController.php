<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RegisterRequest;
use App\Repositories\Domain\UserDomainRepository;
use Illuminate\Http\JsonResponse;

readonly class UserController
{
    public function __construct(private UserDomainRepository $userDomainRepository)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userDomainRepository->createUser(
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        );
        return response()->json([
            'message' => 'User registered successfully',
            'user_id' => $user->getId(),
        ]);
    }
}

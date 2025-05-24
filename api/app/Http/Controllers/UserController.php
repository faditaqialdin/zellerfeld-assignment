<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use App\Repositories\Domain\UserDomainRepository;
use Illuminate\Http\JsonResponse;

readonly class UserController
{
    public function __construct(private UserDomainRepository $userDomainRepository)
    {
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $user = $this->userDomainRepository->createUser(
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        );
        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'user' => $this->userDomainRepository->getUserById($user->id),
        ]);
    }
}

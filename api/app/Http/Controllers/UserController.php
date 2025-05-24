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
        return response()->json($this->userDomainRepository->createUser(
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        ), 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($this->userDomainRepository->getUserById($user->id));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ProfileRequest;
use App\Http\Requests\User\ProfileUpdateRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;
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
            'user' => $user,
        ]);
    }

    public function profile(ProfileRequest $request, User $user = null): JsonResponse
    {
        return response()->json([
            'user' => $this->userDomainRepository->getUserById(
                $user->id ?? $request->user()->id
            ),
        ]);
    }

    public function profileUpdate(ProfileUpdateRequest $request): JsonResponse
    {
        $user = $this->userDomainRepository->updateUser(
            $request->user()->id,
            $request->get('email'),
            $request->get('name'),
            $request->get('password')
        );
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }
}

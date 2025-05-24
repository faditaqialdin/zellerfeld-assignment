<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Repositories\Domain\UserDomainRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class ProfileController
{
    public function __construct(private UserDomainRepository $userDomainRepository)
    {
    }

    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $this->userDomainRepository->getUserById($request->user()->id),
        ]);
    }

    public function update(ProfileUpdateRequest $request): JsonResponse
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

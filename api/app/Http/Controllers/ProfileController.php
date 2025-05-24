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

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->userDomainRepository->getUserById($request->user()->id));
    }

    public function store(ProfileUpdateRequest $request): JsonResponse
    {
        return response()->json($this->userDomainRepository->updateUser(
            $request->user()->id,
            $request->get('email'),
            $request->get('name'),
            $request->get('password')
        ));
    }
}

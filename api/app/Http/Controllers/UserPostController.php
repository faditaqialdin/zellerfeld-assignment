<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Models\User;
use App\Repositories\Domain\PostDomainRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class UserPostController
{
    public function __construct(private PostDomainRepository $postDomainRepository)
    {
    }

    public function index(Request $request, User $user): JsonResponse
    {
        return response()->json($this->postDomainRepository->getUserPostsPaginated(
            $user->id,
            $request->get('limit', 10),
            $request->get('page', 1),
        ));
    }

    public function store(PostStoreRequest $request, User $user): JsonResponse
    {
        return response()->json($this->postDomainRepository->createUserPost(
            $user->id,
            $request->get('content'),
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\Domain\PostDomainRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class PostController
{
    public function __construct(private PostDomainRepository $postDomainRepository)
    {
    }

    public function index(Request $request): JsonResponse
    {
        return response()->json($this->postDomainRepository->getAllPostsPaginated(
            $request->get('limit', 10),
            $request->get('page', 1),
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Repositories\Domain\PostDomainRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * Class PostController
 *
 * Handles operations related to posts, such as retrieving paginated lists of posts.
 */
readonly class PostController
{
    /**
     * PostController constructor.
     *
     * @param PostDomainRepository $postDomainRepository The repository responsible for post-related domain logic.
     */
    public function __construct(private PostDomainRepository $postDomainRepository)
    {
    }

    /**
     * Retrieves a paginated list of posts.
     *
     * @OA\Get(
     *     path="/posts",
     *     summary="Retrieve a paginated list of posts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="The number of posts per page",
     *         required=false,
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The current page number",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of posts",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="meta", type="object", description="Pagination metadata")
     *         )
     *     )
     * )
     *
     * @param Request $request The HTTP request containing pagination parameters.
     * @return JsonResponse A JSON response containing the paginated list of posts.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->postDomainRepository->getAllPostsPaginated(
            $request->get('limit', 10),
            $request->get('page', 1),
        ));
    }
}

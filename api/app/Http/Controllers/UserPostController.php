<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\PostStoreRequest;
use App\Models\User;
use App\Repositories\Domain\PostDomainRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * Class UserPostController
 *
 * @OA\Tag(
 *     name="User Posts",
 *     description="Operations related to a user's posts"
 * )
 *
 * Handles operations related to a user's posts, such as retrieving and creating posts.
 */
readonly class UserPostController
{
    /**
     * UserPostController constructor.
     *
     * @param PostDomainRepository $postDomainRepository The repository responsible for post-related domain logic.
     */
    public function __construct(private PostDomainRepository $postDomainRepository)
    {
    }

    /**
     * Retrieves a paginated list of posts for a specific user.
     *
     * @OA\Get(
     *     path="/users/{userId}/posts",
     *     summary="Retrieve a paginated list of posts for a specific user",
     *     tags={"User Posts"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="The ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
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
     *         description="Successful retrieval of the user's posts",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(type="object")),
     *             @OA\Property(property="meta", type="object", description="Pagination metadata")
     *         )
     *     )
     * )
     *
     * @param Request $request The HTTP request containing pagination parameters.
     * @param User $user The user whose posts are being retrieved.
     *
     * @return JsonResponse A JSON response containing the paginated list of the user's posts.
     */
    public function index(Request $request, User $user): JsonResponse
    {
        return response()->json($this->postDomainRepository->getUserPostsPaginated(
            $user->id,
            $request->get('limit', 10), // Default limit is 10
            $request->get('page', 1),  // Default page is 1
        ));
    }

    /**
     * Creates a new post for a specific user.
     *
     * @OA\Post(
     *     path="/users/{userId}/posts",
     *     summary="Create a new post for a specific user",
     *     tags={"User Posts"},
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="The ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="content", type="string", description="The content of the post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post successfully created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The post ID"),
     *             @OA\Property(property="content", type="string", description="The content of the post"),
     *             @OA\Property(property="user_id", type="integer", description="The ID of the user who created the post")
     *         )
     *     )
     * )
     *
     * @param PostStoreRequest $request The validated request containing the post content.
     * @param User $user The user for whom the post is being created.
     *
     * @return JsonResponse A JSON response containing the created post data and a 201 status code.
     */
    public function store(PostStoreRequest $request, User $user): JsonResponse
    {
        return response()->json($this->postDomainRepository->createUserPost(
            $user->id,
            $request->get('content'),
        ), 201);
    }
}

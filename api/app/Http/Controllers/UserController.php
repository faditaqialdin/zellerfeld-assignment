<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserStoreRequest;
use App\Models\User;
use App\Repositories\Domain\UserDomainRepository;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * Class UserController
 *
 * @OA\Tag(
 *     name="User",
 *     description="Operations related to user management"
 * )
 *
 * Handles operations related to user management, such as creating and retrieving user information.
 */
readonly class UserController
{
    /**
     * UserController constructor.
     *
     * @param UserDomainRepository $userDomainRepository The repository responsible for user-related domain logic.
     */
    public function __construct(private UserDomainRepository $userDomainRepository)
    {
    }

    /**
     * Creates a new user with the provided data.
     *
     * @OA\Post(
     *     path="/users",
     *     summary="Create a new user",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", description="The user's email address"),
     *             @OA\Property(property="name", type="string", description="The user's name"),
     *             @OA\Property(property="password", type="string", description="The user's password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The user's ID"),
     *             @OA\Property(property="email", type="string", description="The user's email address"),
     *             @OA\Property(property="name", type="string", description="The user's name")
     *         )
     *     )
     * )
     *
     * @param UserStoreRequest $request The validated request containing the user's email, name, and password.
     *
     * @return JsonResponse A JSON response containing the created user data and a 201 status code.
     */
    public function store(UserStoreRequest $request): JsonResponse
    {
        return response()->json($this->userDomainRepository->createUser(
            $request->input('email'),
            $request->input('name'),
            $request->input('password')
        ), 201);
    }

    /**
     * Retrieves the details of a specific user by their ID.
     *
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Retrieve a user's details",
     *     tags={"User"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the user",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of the user's details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The user's ID"),
     *             @OA\Property(property="email", type="string", description="The user's email address"),
     *             @OA\Property(property="name", type="string", description="The user's name")
     *         )
     *     )
     * )
     *
     * @param User $user The user model instance resolved by route model binding.
     *
     * @return JsonResponse A JSON response containing the user's details.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($this->userDomainRepository->getUserById($user->id));
    }
}

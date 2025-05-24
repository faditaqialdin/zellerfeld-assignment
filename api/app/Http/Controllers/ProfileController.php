<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Repositories\Domain\UserDomainRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * Class ProfileController
 *
 * @OA\Tag(
 *     name="Profile",
 *     description="Operations related to user profiles"
 * )
 *
 * Handles operations related to user profiles, such as retrieving and updating profile information.
 */
readonly class ProfileController
{
    /**
     * ProfileController constructor.
     *
     * @param UserDomainRepository $userDomainRepository The repository responsible for user-related domain logic.
     */
    public function __construct(private UserDomainRepository $userDomainRepository)
    {
    }

    /**
     * Retrieves the profile information of the currently authenticated user.
     *
     * @OA\Get(
     *     path="/profile",
     *     summary="Retrieve the authenticated user's profile",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of the user's profile",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The user's ID"),
     *             @OA\Property(property="name", type="string", description="The user's name"),
     *             @OA\Property(property="email", type="string", description="The user's email address")
     *         )
     *     )
     * )
     *
     * @param Request $request The HTTP request containing the authenticated user.
     *
     * @return JsonResponse A JSON response containing the user's profile information.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->userDomainRepository->getUserById($request->user()->id));
    }

    /**
     * Updates the profile information of the currently authenticated user.
     *
     * @OA\Patch(
     *     path="/profile",
     *     summary="Update the authenticated user's profile",
     *     tags={"Profile"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="email", type="string", description="The new email address", nullable=true),
     *             @OA\Property(property="name", type="string", description="The new name", nullable=true),
     *             @OA\Property(property="password", type="string", description="The new password", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful update of the user's profile",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", description="The user's ID"),
     *             @OA\Property(property="name", type="string", description="The updated name"),
     *             @OA\Property(property="email", type="string", description="The updated email address")
     *         )
     *     )
     * )
     *
     * @param ProfileUpdateRequest $request The validated request containing the updated profile data.
     *
     * @return JsonResponse A JSON response containing the updated user profile information.
     */
    public function update(ProfileUpdateRequest $request): JsonResponse
    {
        return response()->json($this->userDomainRepository->updateUser(
            $request->user()->id,
            $request->get('email'),
            $request->get('name'),
            $request->get('password')
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use RuntimeException;

/**
 * Class AuthController
 *
 * Handles authentication-related actions such as login and logout.
 */
readonly class AuthController
{
    /**
     * AuthController constructor.
     *
     * @param AuthService $authService The service responsible for handling authentication logic.
     */
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * Logs in a user and generates an access token.
     *
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Log in a user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Logged in successfully"),
     *             @OA\Property(property="access_token", type="string", example="token")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Invalid credentials")
     *         )
     *     )
     * )
     *
     * @param LoginRequest $request The validated login request containing user credentials.
     * @return JsonResponse The response containing the access token or an error message.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $token = $this->authService->createToken(
                $request->input('email'),
                $request->input('password')
            );
            return response()->json([
                'message' => 'Logged in successfully',
                'access_token' => $token,
            ]);
        } catch (RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }

    /**
     * Logs out the currently authenticated user by revoking their token.
     *
     * @OA\Delete(
     *     path="/auth/logout",
     *     summary="Log out a user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LogoutRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Logged out successfully")
     *         )
     *     )
     * )
     *
     * @param LogoutRequest $request The validated logout request containing the authenticated user.
     * @return JsonResponse The response confirming the logout.
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $this->authService->revokeCurrentToken($request->user());
        return response()->json(['message' => 'Logged out successfully']);
    }
}

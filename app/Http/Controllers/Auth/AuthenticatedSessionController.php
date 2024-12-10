<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseApiController;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Registration"
 * )
 */
class AuthenticatedSessionController extends BaseApiController
{
    /**
     * @OA\Get(
     *     path="/user",
     *     summary="Get the authenticated user",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=200,
     *         description="User details retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Authenticate a user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User authenticated successfully"
     *     )
     * )
     *
     * @param LoginRequest $request
     * @return Response
     * @throws ValidationException
     */
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->noContent();
    }

    /**
     * @OA\Delete(
     *     path="/logout",
     *     summary="Logout an authenticated user",
     *     tags={"Authentication"},
     *     @OA\Response(
     *         response=204,
     *         description="User logged out successfully"
     *     )
     * )
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}

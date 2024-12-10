<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseApiController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for User Registration"
 * )
 */
class RegisteredUserController extends BaseApiController
{
    /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="Gabijus"),
     *             @OA\Property(property="email", type="string", format="email", example="gabijus.stukas@gmail.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=2),
     *             @OA\Property(property="name", type="string", example="Gabijus"),
     *             @OA\Property(property="email", type="string", format="email", example="gabijus.stukas@gmail.com"),
     *             @OA\Property(property="country", type="string", nullable=true, example=null),
     *             @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-09T21:48:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-09T21:48:00.000000Z")
     *         )
     *     )
     * )
     *
     * @param RegisterRequest $request
     * @param UserRepository $repository
     * @return Response
     */
    public function store(RegisterRequest $request, UserRepository $repository): Response
    {
        $user = $repository->createUser($request);

        Auth::login($user);

        return response()->noContent();
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\User\ProfileService;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * @OA\Tag(
 *     name="User Endpoints",
 *     description="API Endpoints for authenticated users"
 * )
 */
class UserProfileController extends BaseApiController
{
    /**
     * @OA\Post(
     *     path="/api/user/profile",
     *     summary="Update user profile",
     *     tags={"User Endpoints"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"answer", "question_id"},
     *             @OA\Property(property="answer", type="array", @OA\Items(type="string"), example={"Yes", "No"}),
     *             @OA\Property(property="question_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="string", nullable=true, example=null),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=400),
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(
     *                 property="error",
     *                 type="object",
     *                 @OA\Property(property="code", type="string", nullable=true, example=null),
     *                 @OA\Property(property="message", type="string", example="Answer not valid")
     *             )
     *         )
     *     )
     * )
     *
     * @param ProfileUpdateRequest $request
     * @param ProfileService $profileService
     * @return JsonResponse
     */
    public function store(ProfileUpdateRequest $request, ProfileService $profileService): JsonResponse
    {
        try {
            $profileService->updateProfile($request->toDTO());

            return $this->success();
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

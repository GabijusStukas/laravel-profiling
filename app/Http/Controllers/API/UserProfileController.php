<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\User\ProfileService;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserProfileController extends BaseApiController
{
    /**
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

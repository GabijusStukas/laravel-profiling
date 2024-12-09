<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Services\UserWalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserWalletController extends BaseApiController
{
    /**
     * @param Request $request
     * @param UserWalletService $service
     * @return JsonResponse
     */
    public function show(Request $request, UserWalletService $service): JsonResponse
    {
        try {
            return $this->success(
                $service->getUserWallet($request->user()->id)
            );
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

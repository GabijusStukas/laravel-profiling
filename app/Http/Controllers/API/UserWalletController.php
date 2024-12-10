<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Services\User\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * @OA\Tag(
 *     name="User Endpoints",
 *     description="API Endpoints for users"
 * )
 */
class UserWalletController extends BaseApiController
{
    /**
     * @OA\Get(
     *     path="/api/user/wallet",
     *     summary="Get user wallet information",
     *     tags={"User Endpoints"},
     *     @OA\Response(
     *         response=200,
     *         description="User wallet information",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="balance", type="number", format="float", example=0),
     *                 @OA\Property(property="unclaimed_balance", type="number", format="float", example=0.1),
     *                 @OA\Property(property="unclaimed_transactions", type="integer", example=2)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Internal Server Error"
     *     )
     * )
     *
     * @param Request $request
     * @param WalletService $service
     * @return JsonResponse
     */
    public function show(Request $request, WalletService $service): JsonResponse
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

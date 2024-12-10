<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Repositories\PointsTransactionRepository;
use App\Transformers\PointsTransactionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * @OA\Tag(
 *     name="User Endpoints",
 *     description="API Endpoints for users"
 * )
 */
class PointsTransactionsController extends BaseApiController
{
    /**
     * @OA\Get(
     *     path="/api/user/points-transactions",
     *     summary="Get list of points transactions",
     *     tags={"User Endpoints"},
     *     @OA\Response(
     *         response=200,
     *         description="List of points transactions",
     *         @OA\JsonContent(ref="#/components/schemas/PointsTransactionResponse")
     *     )
     * )
     *
     * @param Request $request
     * @param PointsTransactionRepository $repository
     * @return JsonResponse
     */
    public function index(Request $request, PointsTransactionRepository $repository): JsonResponse
    {
        try {
            return $this->success(
                $repository->getTransactionsByUserId($request->user()->id),
                PointsTransactionTransformer::class
            );
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

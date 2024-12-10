<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\PointsTransaction;
use App\Repositories\PointsTransactionRepository;
use App\Transformers\PointsTransactionTransformer;
use Flugg\Responder\Responder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * @OA\Tag(
 *     name="User Endpoints",
 *     description="API Endpoints for authenticated users"
 * )
 */
class PointsTransactionsController extends BaseApiController
{
    /**
     * @param PointsTransactionRepository $repository
     * @param Responder $responder
     */
    public function __construct(private PointsTransactionRepository $repository, Responder $responder)
    {
        parent::__construct($responder);
    }

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
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            return $this->success(
                $this->repository->getTransactionsByUserId($request->user()->id),
                PointsTransactionTransformer::class
            );
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     *     path="/api/user/points-transactions/{pointsTransaction}",
     *     summary="Claim a points transaction",
     *     tags={"User Endpoints"},
     *     @OA\Parameter(
     *         name="pointsTransaction",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the points transaction to claim"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Transaction updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="string", nullable=true, example=null),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Internal Server Error"
     *     )
     * )
     *
     * @param Request $request
     * @param PointsTransaction $pointsTransaction
     * @return JsonResponse
     */
    public function update(Request $request, PointsTransaction $pointsTransaction): JsonResponse
    {
        try {
            $this->repository->claimTransaction($request->user()->id, $pointsTransaction);

            return $this->success();
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\PointsTransaction;
use App\Transformers\PointsTransactionTransformer;
use Illuminate\Http\JsonResponse;
use Throwable;

class PointsTransactionsController extends BaseApiController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return $this->success(
                PointsTransaction::query()->paginate(),
                PointsTransactionTransformer::class
            );
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

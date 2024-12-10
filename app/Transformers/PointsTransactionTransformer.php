<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\PointsTransaction;
use Flugg\Responder\Transformers\Transformer;

/**
 * @OA\Schema(
 *     schema="PointsTransactionResponse",
 *     type="object",
 *     @OA\Property(property="status", type="integer", example=200),
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PointsTransaction")
 *     ),
 *     @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 * )
 */
class PointsTransactionTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $relations = [];

    /**
     * @var array
     */
    protected $load = [];

    /**
     * @param PointsTransaction $pointsTransaction
     * @return array
     */
    public function transform(PointsTransaction $pointsTransaction): array
    {
        return [
            'id' => $pointsTransaction->id,
            'points' => $pointsTransaction->points,
            'claimed_at' => $pointsTransaction->claimed_at,
            'created_at' => $pointsTransaction->created_at,
            'updated_at' => $pointsTransaction->updated_at,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\PointsTransaction;
use Flugg\Responder\Transformers\Transformer;

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

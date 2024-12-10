<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PointsTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PointsTransactionRepository
{
    /**
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function getTransactionsByUserId(int $userId)
    {
        return PointsTransaction::query()->where('user_id', $userId)->paginate();
    }

    /**
     * @param int $userId
     * @return PointsTransaction
     */
    public function createNewTransaction(int $userId): PointsTransaction
    {
        return PointsTransaction::query()->create([
            'user_id' => $userId,
            'points' => PointsTransaction::DEFAULT_POINTS,
        ]);
    }
}

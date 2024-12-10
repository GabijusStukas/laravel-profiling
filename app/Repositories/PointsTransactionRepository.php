<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Exceptions\ProfileUpdateException;
use App\Models\PointsTransaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Throwable;

class PointsTransactionRepository
{
    /**
     * @param UserWalletRepository $userWalletRepository
     */
    public function __construct(private UserWalletRepository $userWalletRepository)
    {
    }

    /**
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function getTransactionsByUserId(int $userId): LengthAwarePaginator
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

    /**
     * @param int $userId
     * @param PointsTransaction $transaction
     * @return PointsTransaction
     * @throws ProfileUpdateException
     */
    public function claimTransaction(int $userId, PointsTransaction $transaction): PointsTransaction
    {
        if ($transaction->user_id !== $userId) {
            throw new ProfileUpdateException('Unable to claim transaction');
        }

        if ($transaction->claimed_at) {
            throw new ProfileUpdateException('Transaction already claimed');
        }

        $lock = Cache::lock('transaction_claim_' . $transaction->id, 10);
        if (!$lock->get()) {
            throw new ProfileUpdateException('Profile update is currently in progress. Please try again later.');
        }

        try {
            $this->userWalletRepository->addPointsToUserWallet($userId, $transaction->points);

            $transaction->claimed_at = now();
            $transaction->save();

            return $transaction;
        } catch (Throwable $exception) {
            throw new ProfileUpdateException($exception->getMessage());
        } finally {
            $lock->release();
        }
    }
}

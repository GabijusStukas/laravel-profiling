<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Repositories\UserWalletRepository;

class WalletService
{
    private const POINTS_TO_USD = 0.01;

    /**
     * @param UserWalletRepository $repository
     */
    public function __construct(private UserWalletRepository $repository)
    {
    }

    /**
     * @param int $userId
     * @return array
     */
    public function getUserWallet(int $userId): array
    {
        $user = $this->repository->getUserWallet($userId);

        return [
            'balance' => $user->userWallet?->balance ?? 0,
            'unclaimed_balance' => $user->pointsTransactions->sum('points') * self::POINTS_TO_USD,
            'unclaimed_transactions' => $user->pointsTransactions->whereNull('claimed_at')->count(),
        ];
    }
}
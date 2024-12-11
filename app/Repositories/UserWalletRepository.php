<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\UserWallet;

class UserWalletRepository
{
    /**
     * @param int $userId
     * @return User
     */
    public function getUserWallet(int $userId): User
    {
        return User::query()->with(['userWallet', 'pointsTransactions'])->find($userId);
    }

    /**
     * @param int $userId
     * @param float $points
     * @return UserWallet
     */
    public function addPointsToUserWallet(int $userId, float $points): UserWallet
    {
        $wallet = UserWallet::query()->firstOrCreate(['user_id' => $userId]);

        $wallet->balance += $points;
        $wallet->save();

        return $wallet;
    }
}

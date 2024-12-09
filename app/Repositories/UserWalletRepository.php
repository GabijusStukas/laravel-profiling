<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

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
}

<?php

declare(strict_types=1);

namespace App\Services\Statistics;

use App\Models\PointsTransaction;
use App\Models\UserWallet;
use App\Models\TransactionStatistic;
use Illuminate\Support\Facades\Log;
use Throwable;

class DailyStatisticsService
{
    /**
     * @return void
     */
    public function calculateDailyPoints(): void
    {
        try {
            $date = now()->subDay();

            $transactions = PointsTransaction::query()->whereDate('created_at', $date)->get();

            TransactionStatistic::query()->updateOrCreate(
                ['date' => $date->toDateString()],
                [
                    'points_transactions_created' => $transactions->count(),
                    'points_transactions_claimed' => $transactions->whereNotNull('claimed_at')->count(),
                    'usd_claimed' => $transactions->whereNotNull('claimed_at')->sum('points') * UserWallet::POINTS_TO_USD,
                ]
            );
        } catch (Throwable $exception) {
            Log::error('DailyStatisticsService: failed to calculate daily points', [
                'error' => $exception->getMessage(),
            ]);
        }
    }
}

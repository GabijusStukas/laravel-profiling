<?php

namespace Tests\Feature\Console;

use App\Models\PointsTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CalculateDailyStatsCommandTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testCalculateDailyStatsCommand(): void
    {
        $user = User::factory()->create();

        /** @var PointsTransaction $transaction */
        PointsTransaction::factory()->create([
            'user_id' => $user->id,
            'created_at' => now()->subDay()
        ]);

        /** @var PointsTransaction $transactionTwo */
        PointsTransaction::factory()->create(
            ['user_id' => $user->id,
                'created_at' => now()->subDay(),
                'claimed_at' => null
            ]);

        Artisan::call('app:calculate-daily-stats');

        $this->assertDatabaseHas('transaction_statistics', [
            'date' => now()->subDay()->toDateString(),
            'points_transactions_created' => 2,
            'points_transactions_claimed' => 1,
        ]);
    }
}

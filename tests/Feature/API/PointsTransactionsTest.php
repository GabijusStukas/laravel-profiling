<?php

namespace Tests\Feature\API;

use App\Models\PointsTransaction;
use App\Models\User;
use App\Repositories\PointsTransactionRepository;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class PointsTransactionsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testGetUserPointsTransactions(): void
    {
        $user = User::factory()->create();
        /** @var PointsTransaction $transaction */
        $transaction = PointsTransaction::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('points-transactions.index'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'success' => true,
                'data' => [
                    [
                        'id' => $transaction->id,
                        'points' => $transaction->points,
                        'claimed_at' => $transaction->claimed_at->toISOString(),
                    ],
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testGetProfilingQuestionsException(): void
    {
        $user = User::factory()->create();

        $exceptionMessage = 'Test Exception';

        $this->mock(PointsTransactionRepository::class)
            ->shouldReceive('getTransactionsByUserId')
            ->andThrow(new Exception($exceptionMessage));

        $response = $this->actingAs($user)->getJson(route('points-transactions.index'));

        $response->assertStatus(400)
            ->assertJson([
                'status' => 400,
                'success' => false,
                'error' => [
                    'code' => null,
                    'message' => $exceptionMessage
                ]
            ]);
    }

    /**
     * @return void
     */
    public function testStorePointsTransactionUnauthorized(): void
    {
        $response = $this->getJson(route('points-transactions.index'));

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * @return void
     */
    public function testClaimPointsTransactionSuccessfully(): void
    {
        $user = User::factory()->create();
        /** @var PointsTransaction $transaction */
        $transaction = PointsTransaction::factory()->create(['user_id' => $user->id, 'claimed_at' => null]);

        $response = $this->actingAs($user)->postJson(route('points-transactions.update', $transaction->id));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'success' => true,
                'data' => null,
            ]);

        $this->assertNotNull($transaction->fresh()->claimed_at);
    }

    /**
     * @return void
     */
    public function testClaimPointsTransactionAlreadyClaimed(): void
    {
        $user = User::factory()->create();
        $transaction = PointsTransaction::factory()->create(['user_id' => $user->id, 'claimed_at' => now()]);

        $response = $this->actingAs($user)->postJson(route('points-transactions.update', $transaction->id));

        $response->assertStatus(400)
            ->assertJson([
                'status' => 400,
                'success' => false,
                'error' => [
                    'message' => 'Transaction already claimed',
                ],
            ]);
    }

    /**
     * @return void
     */
    public function testClaimPointsTransactionUnauthorized(): void
    {
        $transaction = PointsTransaction::factory()->create();

        $response = $this->postJson(route('points-transactions.update', $transaction->id));

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    /**
     * @return void
     */
    public function testClaimAnotherUserTransaction(): void
    {
        $user = User::factory()->create();
        $userTwo = User::factory()->create();
        $transaction = PointsTransaction::factory()->create(['user_id' => $userTwo->id, 'claimed_at' => null]);

        $response = $this->actingAs($user)->postJson(route('points-transactions.update', $transaction->id));

        $response->assertStatus(400)
            ->assertJson([
                'status' => 400,
                'success' => false,
                'error' => [
                    'message' => 'Unable to claim transaction',
                ],
            ]);
    }
}

<?php

namespace Tests\Feature\API;

use App\Models\User;
use App\Models\UserWallet;
use App\Services\User\WalletService;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserWalletTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function testGetSuccessfulUserWallet(): void
    {
        $user = User::factory()->create();
        $userWallet = UserWallet::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson(route('user-wallet.show'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'success' => true,
                'data' => ['balance' => $userWallet->balance]
            ]);
    }

    /**
     * @return void
     */
    public function testGetUserWalletException(): void
    {
        $user = User::factory()->create();
        UserWallet::factory()->create(['user_id' => $user->id]);

        $exceptionMessage = 'Test Exception';

        $this->mock(WalletService::class)
            ->shouldReceive('getUserWallet')
            ->andThrow(new Exception($exceptionMessage));

        $response = $this->actingAs($user)->getJson(route('user-wallet.show'));

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
    public function testGetUserWalletWhileUnauthorized(): void
    {
        $response = $this->getJson(route('user-wallet.show'));

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }
}

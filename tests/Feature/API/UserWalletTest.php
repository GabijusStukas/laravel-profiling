<?php

namespace Tests\Feature\API;

use App\Models\User;
use App\Models\UserWallet;
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
}

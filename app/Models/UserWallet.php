<?php

namespace App\Models;

use Database\Factories\UserWalletFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property float $balance
 */
class UserWallet extends Model
{
    /** @use HasFactory<UserWalletFactory> */
    use HasFactory;

    public const POINTS_TO_USD = 0.01;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'balance' => 'float',
    ];
}

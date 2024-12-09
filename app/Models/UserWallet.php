<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $balance
 */
class UserWallet extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'balance',
    ];
}

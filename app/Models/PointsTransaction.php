<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $points
 * @property string $claimed_at
 * @property string $created_at
 * @property string $updated_at
 */
class PointsTransaction extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'points',
        'claimed_at',
    ];
}

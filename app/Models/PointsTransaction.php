<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="PointsTransaction",
 *      type="object",
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="user_id", type="integer", example=1),
 *      @OA\Property(property="points", type="integer", example=100),
 *      @OA\Property(property="claimed_at", type="string", nullable=true, format="date-time", example="2023-01-01T00:00:00Z"),
 *      @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T00:00:00Z"),
 *      @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T00:00:00Z")
 * )
 *
 * @property int $id
 * @property int $user_id
 * @property int $points
 * @property string $claimed_at
 * @property string $created_at
 * @property string $updated_at
 */
class PointsTransaction extends Model
{
    public const DEFAULT_POINTS = 5;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'points',
        'claimed_at',
    ];
}

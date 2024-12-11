<?php

namespace App\Models;

use Database\Factories\ProfilingQuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *     schema="ProfilingQuestion",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="question", type="string", example="What is your gender?"),
 *     @OA\Property(property="type", type="string", example="single-choice"),
 *     @OA\Property(
 *         property="options",
 *         type="array",
 *         @OA\Items(type="string"),
 *         example={"Male", "Female"}
 *     ),
 *     @OA\Property(property="answer", type="string", nullable=true, example="Male"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-09T21:52:40.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-09T21:52:40.000000Z")
 * )
 *
 * @property int $id
 * @property string $question
 * @property string $type
 * @property array $options
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Collection<int, UserProfile> $userProfiles
 */
class ProfilingQuestion extends Model
{
    /** @use HasFactory<ProfilingQuestionFactory> */
    use HasFactory;

    public const TYPE_MULTIPLE_CHOICE = 'multiple-choice';
    public const TYPE_SINGLE_CHOICE = 'single-choice';
    public const TYPE_DATE = 'date';
    public const TYPE_OPEN = 'open';

    public const TYPES = [
        self::TYPE_MULTIPLE_CHOICE,
        self::TYPE_SINGLE_CHOICE,
        self::TYPE_DATE,
        self::TYPE_OPEN
    ];

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'type',
        'options',
    ];

    /**
     * @var array<string, string> $casts
     */
    protected $casts = [
        'options' => 'array',
    ];

    /**
     * @return HasMany
     */
    public function userProfiles(): HasMany
    {
        return $this->hasMany(UserProfile::class);
    }
}

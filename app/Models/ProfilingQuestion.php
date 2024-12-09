<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $question
 * @property string $type
 * @property array $options
 * @property string $created_at
 * @property string $updated_at
 */
class ProfilingQuestion extends Model
{
    /** @use HasFactory<UserFactory> */
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
}

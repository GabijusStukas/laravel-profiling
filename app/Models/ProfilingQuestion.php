<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id
 * @property string $question
 * @property string $type
 * @property string $options
 * @property string $created_at
 * @property string $updated_at
 */
class ProfilingQuestion extends Model
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const TYPES = [
        'multiple-choice',
        'single-choice',
        'date',
        'open'
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

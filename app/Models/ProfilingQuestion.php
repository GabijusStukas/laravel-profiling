<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

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
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question',
        'type',
        'options',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property int $profiling_question_id
 * @property string $answer
 * @property string $created_at
 * @property string $updated_at
 */
class UserProfile extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'profiling_question_id',
        'answer',
    ];
}

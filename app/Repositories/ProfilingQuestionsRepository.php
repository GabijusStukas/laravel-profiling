<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ProfilingQuestion;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProfilingQuestionsRepository
{
    /**
     * @param int $userId
     * @return LengthAwarePaginator
     */
    public function getUserProfilingQuestions(int $userId): LengthAwarePaginator
    {
        return ProfilingQuestion::with(['userProfiles' => function ($query) use ($userId) {
            $query->where('user_id', '=', $userId);
        }])->paginate();
    }
}

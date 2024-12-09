<?php

declare(strict_types=1);

namespace App\Repositories;

use App\DTOs\ProfileUpdateDTO;
use App\Models\UserProfile;

class UserProfileRepository
{
    /**
     * @param int $userId
     * @return bool
     */
    public function userHasUpdatedProfileToday(int $userId): bool
    {
        return UserProfile::query()
            ->where('user_id', $userId)
            ->where('created_at', '>=', now()->subDay())
            ->exists();
    }

    /**
     * @param int $userId
     * @param int $profilingQuestionId
     * @return bool
     */
    public function isQuestionAlreadyAnswered(int $userId, int $profilingQuestionId): bool
    {
        return UserProfile::query()
            ->where('user_id', $userId)
            ->where('profiling_question_id', $profilingQuestionId)
            ->exists();
    }

    /**
     * @param ProfileUpdateDTO $dto
     * @return void
     */
    public function save(ProfileUpdateDTO $dto): void
    {
        $userProfile = new UserProfile();

        $userProfile->user_id = $dto->getUserId();
        $userProfile->profiling_question_id = $dto->getQuestionId();
        $userProfile->answer = $dto->getAnswer();

        $userProfile->save();
    }
}

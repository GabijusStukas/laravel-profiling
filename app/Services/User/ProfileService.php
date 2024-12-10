<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;
use App\Repositories\UserProfileRepository;
use App\Services\Profiling\QuestionHandlerFactory;
use Illuminate\Support\Facades\Cache;

class ProfileService
{
    /**
     * @param UserProfileRepository $userProfileRepository
     * @param QuestionHandlerFactory $factory
     */
    public function __construct(
        private UserProfileRepository $userProfileRepository,
        private QuestionHandlerFactory $factory,
    ) {
    }

    /**
     * @param ProfileUpdateDTO $dto
     * @return bool
     * @throws ProfileUpdateException
     */
    public function updateProfile(ProfileUpdateDTO $dto): bool
    {
        $lock = Cache::lock('profile_update_lock_' . $dto->getUserId(), 10);
        if (!$lock->get()) {
            throw new ProfileUpdateException('Profile update is currently in progress. Please try again later.');
        }

        try {
            if ($this->userProfileRepository->userHasUpdatedProfileToday($dto->getUserId())) {
                throw new ProfileUpdateException('You can only update your profile once a day');
            }

            $question = ProfilingQuestion::query()->find($dto->getQuestionId());
            if (!$question) {
                throw new ProfileUpdateException('Question not found');
            }

            if ($this->userProfileRepository->isQuestionAlreadyAnswered($dto->getUserId(), $dto->getQuestionId())) {
                throw new ProfileUpdateException('You have already answered this question');
            }

            $this->factory->create($question->type)->handle($question, $dto);

            return true;
        } finally {
            $lock->release();
        }
    }
}

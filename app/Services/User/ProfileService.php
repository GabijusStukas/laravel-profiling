<?php

declare(strict_types=1);

namespace App\Services\User;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;
use App\Repositories\UserProfileRepository;
use App\Services\Profiling\QuestionHandlerFactory;

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
    }
}

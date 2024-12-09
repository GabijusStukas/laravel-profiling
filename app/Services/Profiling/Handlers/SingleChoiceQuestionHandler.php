<?php

declare(strict_types=1);

namespace App\Services\Profiling\Handlers;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;

class SingleChoiceQuestionHandler extends AbstractQuestionHandler
{
    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     * @throws ProfileUpdateException
     */
    protected function updateProfile(ProfilingQuestion $question, ProfileUpdateDTO $dto): void
    {
        if (! in_array($dto->getAnswer(), $question->options)) {
            throw new ProfileUpdateException('Invalid answer');
        }

        $this->profileRepository->save($dto);
    }
}

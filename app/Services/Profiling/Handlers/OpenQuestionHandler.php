<?php

declare(strict_types=1);

namespace App\Services\Profiling\Handlers;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;

class OpenQuestionHandler extends AbstractQuestionHandler
{
    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     * @throws ProfileUpdateException
     */
    public function updateProfile(ProfilingQuestion $question, ProfileUpdateDTO $dto): void
    {
        if (!is_string($dto->getAnswer())) {
            throw new ProfileUpdateException('Answer must be a string');
        }

        $this->profileRepository->save($dto);
    }
}

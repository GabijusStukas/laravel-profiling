<?php

declare(strict_types=1);

namespace App\Services\Profiling\Handlers;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;

class DateQuestionHandler extends AbstractQuestionHandler
{
    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     * @throws ProfileUpdateException
     */
    protected function isAnswerValid(ProfilingQuestion $question, ProfileUpdateDTO $dto): void
    {
        if (!strtotime($dto->getAnswer())) {
            throw new ProfileUpdateException('Invalid date format');
        }
    }
}

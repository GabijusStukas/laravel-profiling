<?php

declare(strict_types=1);

namespace App\Services\Profiling\Handlers;

use App\DTOs\ProfileUpdateDTO;
use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;

class MultipleChoiceQuestionHandler extends AbstractQuestionHandler
{
    /**
     * @param ProfilingQuestion $question
     * @param ProfileUpdateDTO $dto
     * @return void
     * @throws ProfileUpdateException
     */
    protected function isAnswerValid(ProfilingQuestion $question, ProfileUpdateDTO $dto): void
    {
        if (!is_array($dto->getAnswer())) {
            throw new ProfileUpdateException('Invalid answer format');
        }

        foreach ($dto->getAnswer() as $answer) {
            if (!is_string($answer)) {
                throw new ProfileUpdateException('Invalid answer format');
            }

            if (!in_array($answer, $question->options)) {
                throw new ProfileUpdateException('Invalid answer ' . $answer);
            }
        }
    }
}

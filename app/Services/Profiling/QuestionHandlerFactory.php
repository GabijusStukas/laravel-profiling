<?php

declare(strict_types=1);

namespace App\Services\Profiling;

use App\Exceptions\ProfileUpdateException;
use App\Models\ProfilingQuestion;
use App\Services\Profiling\Handlers\AbstractQuestionHandler;
use App\Services\Profiling\Handlers\DateQuestionHandler;
use App\Services\Profiling\Handlers\MultipleChoiceQuestionHandler;
use App\Services\Profiling\Handlers\OpenQuestionHandler;
use App\Services\Profiling\Handlers\SingleChoiceQuestionHandler;

class QuestionHandlerFactory
{
    /**
     * @param string $questionType
     * @return AbstractQuestionHandler
     * @throws ProfileUpdateException
     */
    public function create(string $questionType): AbstractQuestionHandler
    {
        return match ($questionType) {
            ProfilingQuestion::TYPE_OPEN => app(OpenQuestionHandler::class),
            ProfilingQuestion::TYPE_SINGLE_CHOICE => app(SingleChoiceQuestionHandler::class),
            ProfilingQuestion::TYPE_DATE => app(DateQuestionHandler::class),
            ProfilingQuestion::TYPE_MULTIPLE_CHOICE => app(MultipleChoiceQuestionHandler::class),
            default => throw new ProfileUpdateException("Unknown question type: $questionType"),
        };
    }
}

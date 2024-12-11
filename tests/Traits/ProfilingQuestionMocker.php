<?php

namespace Tests\Traits;

use App\Models\ProfilingQuestion;
use Exception;

trait ProfilingQuestionMocker
{
    /**
     * @param string $type
     * @param mixed|null $options
     * @return ProfilingQuestion
     * @throws Exception
     */
    public function createQuestion(
        string $type,
        mixed $options = null
    ): ProfilingQuestion {
        return match ($type) {
            ProfilingQuestion::TYPE_SINGLE_CHOICE => ProfilingQuestion::factory()->create([
                'type' => ProfilingQuestion::TYPE_SINGLE_CHOICE,
                'options' => $options ?? ['Option 1', 'Option 2', 'Option 3'],
            ]),
            ProfilingQuestion::TYPE_MULTIPLE_CHOICE => ProfilingQuestion::factory()->create([
                'type' => ProfilingQuestion::TYPE_MULTIPLE_CHOICE,
                'options' => $options ?? ['Option 1', 'Option 2', 'Option 3', 'Option 4'],
            ]),
            ProfilingQuestion::TYPE_DATE => ProfilingQuestion::factory()->create([
                'type' => ProfilingQuestion::TYPE_DATE,
                'options' => null,
            ]),
            ProfilingQuestion::TYPE_OPEN => ProfilingQuestion::factory()->create([
                'type' => ProfilingQuestion::TYPE_OPEN,
                'options' => null,
            ]),
            default => throw new Exception("Unsupported question type: $type"),
        };
    }
}

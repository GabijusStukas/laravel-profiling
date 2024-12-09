<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\ProfilingQuestion;
use Flugg\Responder\Transformers\Transformer;

class ProfilingQuestionTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $relations = [];

    /**
     * @var array
     */
    protected $load = [];

    /**
     * @param ProfilingQuestion $profilingQuestion
     * @return array
     */
    public function transform(ProfilingQuestion $profilingQuestion): array
    {
        return [
            'id' => $profilingQuestion->id,
            'question' => $profilingQuestion->question,
            'type' => $profilingQuestion->type,
            'options' => $profilingQuestion->options,
            'created_at' => $profilingQuestion->created_at,
            'updated_at' => $profilingQuestion->updated_at,
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Models\ProfilingQuestion;
use Flugg\Responder\Transformers\Transformer;

/**
 * @OA\Schema(
 *     schema="ProfilingQuestionResponse",
 *     type="object",
 *     @OA\Property(property="status", type="integer", example=200),
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ProfilingQuestion")
 *     ),
 *     @OA\Property(property="pagination", ref="#/components/schemas/Pagination")
 * )
 */
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
            'answer' => $profilingQuestion->userProfiles->first()?->answer,
            'created_at' => $profilingQuestion->created_at,
            'updated_at' => $profilingQuestion->updated_at,
        ];
    }
}

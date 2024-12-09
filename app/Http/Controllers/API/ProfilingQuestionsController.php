<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Models\ProfilingQuestion;
use App\Transformers\ProfilingQuestionTransformer;
use Illuminate\Http\JsonResponse;
use Throwable;

class ProfilingQuestionsController extends BaseApiController
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            return $this->success(
                ProfilingQuestion::query()->paginate(),
                ProfilingQuestionTransformer::class
            );
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

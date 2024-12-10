<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Repositories\ProfilingQuestionsRepository;
use App\Transformers\ProfilingQuestionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

/**
 * @OA\Tag(
 *     name="User Endpoints",
 *     description="API Endpoints for authenticated users"
 * )
 */
class ProfilingQuestionsController extends BaseApiController
{
    /**
     * @OA\Get(
     *     path="/api/user/profiling-questions",
     *     summary="Get list of available profiling questions",
     *     tags={"User Endpoints"},
     *     @OA\Response(
     *         response=200,
     *         description="List of profiling questions",
     *         @OA\JsonContent(ref="#/components/schemas/ProfilingQuestionResponse")
     *     )
     * )
     *
     * @param Request $request
     * @param ProfilingQuestionsRepository $repository
     * @return JsonResponse
     */
    public function index(Request $request, ProfilingQuestionsRepository $repository): JsonResponse
    {
        try {
            return $this->success(
                $repository->getUserProfilingQuestions($request->user()->id),
                ProfilingQuestionTransformer::class
            );
        } catch (Throwable $exception) {
            return $this->error(message: $exception->getMessage());
        }
    }
}

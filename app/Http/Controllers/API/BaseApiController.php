<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use Flugg\Responder\Responder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BaseApiController extends Controller
{
    /**
     * @param Responder $responder
     */
    public function __construct(protected Responder $responder)
    {
    }

    /**
     * @param mixed|null $data
     * @param string|null $transformer
     * @param int $status
     * @return JsonResponse
     */
    protected function success(
        mixed $data = null,
        ?string $transformer = null,
        int $status = Response::HTTP_OK
    ): JsonResponse {
        return $this->responder
            ->success($data, $transformer)
            ->respond($status);
    }

    /**
     * @param int|null $errorCode
     * @param string|null $message
     * @param int $status
     * @return JsonResponse
     */
    protected function error(
        ?int $errorCode = null,
        ?string $message = null,
        int $status = Response::HTTP_BAD_REQUEST
    ): JsonResponse {
        return $this->responder
            ->error($errorCode, $message)
            ->respond($status);
    }
}

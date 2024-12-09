<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Proxycheck\ProxyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictVPN
{
    /**
     * @param ProxyService $proxyService
     */
    public function __construct(private ProxyService $proxyService)
    {
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->proxyService->isProxy($request->ip())) {
            return response()->json(['message' => 'VPNs or proxies are not allowed'], 403);
        }

        return $next($request);
    }
}

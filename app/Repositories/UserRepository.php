<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Proxycheck\ProxyService;

class UserRepository
{
    /**
     * @param ProxyService $proxyService
     */
    public function __construct(private ProxyService $proxyService)
    {
    }

    /**
     * @param RegisterRequest $request
     * @return User
     */
    public function createUser(RegisterRequest $request): User
    {
        $data = $request->validated();
        $data['country'] = $this->proxyService->getCountryByIpAddress($request->ip());

        return User::query()->create($data);
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @param UserRepository $repository
     * @return Response
     */
    public function store(RegisterRequest $request, UserRepository $repository): Response
    {
        $user = $repository->createUser($request);

        Auth::login($user);

        return response()->noContent();
    }
}

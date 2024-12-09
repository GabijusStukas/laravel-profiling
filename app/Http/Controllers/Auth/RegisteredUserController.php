<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return Response
     */
    public function store(RegisterRequest $request): Response
    {
        $user = User::query()->create($request->validated());

        Auth::login($user);

        return response()->noContent();
    }
}

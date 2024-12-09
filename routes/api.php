<?php

use App\Http\Controllers\API\PointsTransactionsController;
use App\Http\Controllers\API\ProfilingQuestionsController;
use App\Http\Controllers\API\UserWalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/wallet', [UserWalletController::class, 'show']);
    Route::get('/user/points-transactions', [PointsTransactionsController::class, 'index']);

    Route::get('/profiling-questions', [ProfilingQuestionsController::class, 'index']);

});

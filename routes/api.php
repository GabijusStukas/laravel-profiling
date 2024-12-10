<?php

use App\Http\Controllers\API\PointsTransactionsController;
use App\Http\Controllers\API\ProfilingQuestionsController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\UserWalletController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user/wallet', [UserWalletController::class, 'show']);
    Route::get('/user/points-transactions', [PointsTransactionsController::class, 'index']);
    Route::post('/user/profile', [UserProfileController::class, 'store']);
    Route::get('/user/profiling-questions', [ProfilingQuestionsController::class, 'index']);

});

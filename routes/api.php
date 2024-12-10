<?php

use App\Http\Controllers\API\PointsTransactionsController;
use App\Http\Controllers\API\ProfilingQuestionsController;
use App\Http\Controllers\API\UserProfileController;
use App\Http\Controllers\API\UserWalletController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user/wallet', [UserWalletController::class, 'show'])->name('user-wallet.show');
    Route::post('/user/profile', [UserProfileController::class, 'store'])->name('user-profile.store');
    Route::get('/user/profiling-questions', [ProfilingQuestionsController::class, 'index'])->name('profiling-questions.index');

    Route::get('/user/points-transactions', [PointsTransactionsController::class, 'index'])->name('points-transactions.index');
    Route::post('/user/points-transactions/{pointsTransaction}', [PointsTransactionsController::class, 'update'])->name('points-transactions.update');

});

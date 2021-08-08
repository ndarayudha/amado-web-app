<?php

use App\Http\Controllers\ApiWeb\DoctorAuthController;
use App\Http\Controllers\ApiWeb\ForgotPasswordController;
use Illuminate\Support\Facades\Route;


Route::prefix('doctor')->group(function () {

    Route::post('/v1/register', [DoctorAuthController::class, 'register']);
    Route::post('/v1/login', [DoctorAuthController::class, 'login']);
    Route::post('/v1/logout', [DoctorAuthController::class, 'logout']);
    Route::post('/v1/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/v1/reset-password', [ForgotPasswordController::class, 'resetPassword']);

    Route::group(['middleware' => 'auth:doctor-api'], function () {
    });
});

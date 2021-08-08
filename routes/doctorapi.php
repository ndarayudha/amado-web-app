<?php

use App\Http\Controllers\ApiWeb\DoctorAuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('doctor')->group(function () {

    Route::post('/v1/register', [DoctorAuthController::class, 'register']);
    Route::post('/v1/login', [DoctorAuthController::class, 'login']);
    Route::post('/v1/logout', [DoctorAuthController::class, 'logout']);

    Route::group(['namespace' => 'Doctor', 'middleware' => 'auth:doctor-api'], function () {
    });
});

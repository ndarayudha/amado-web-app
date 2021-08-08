<?php

use App\Http\Controllers\ApiWeb\DoctorAuthController;
use App\Http\Controllers\ApiWeb\DoctorProfileController;
use App\Http\Controllers\ApiWeb\ForgotPasswordController;
use Illuminate\Support\Facades\Route;


Route::prefix('doctor')->group(function () {

    Route::post('/v1/register', [DoctorAuthController::class, 'register']);
    Route::post('/v1/login', [DoctorAuthController::class, 'login']);
    Route::post('/v1/logout', [DoctorAuthController::class, 'logout']);
    Route::post('/v1/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/v1/reset-password', [ForgotPasswordController::class, 'resetPassword']);

    // get biodata dokter
    Route::get('/bio', [DoctorProfileController::class, 'getBiodata']);

    Route::group(['middleware' => 'auth:doctor-api'], function () {

        // * Update Biodata
        Route::post('/update', [DoctorProfileController::class, 'update']);

        // * Update Foto Profil
        Route::post('/add-profile-photo', [DoctorProfileController::class, 'saveUserProfile']);

        // * Ambil Foto Profile
        Route::post('/user-profile', [DoctorProfileController::class, 'getUserPhoto']);
    });
});

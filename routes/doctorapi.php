<?php

use App\Http\Controllers\ApiWeb\DoctorAuthController;
use App\Http\Controllers\ApiWeb\DoctorProfileController;
use App\Http\Controllers\ApiWeb\ForgotPasswordController;
use App\Http\Controllers\Api\Patient\PatientProfileController;
use App\Http\Controllers\Api\Geolocation\GeolocationController;
use App\Http\Controllers\MonitoringController;
use Illuminate\Support\Facades\Route;


Route::prefix('doctor')->group(function () {

    Route::post('/v1/register', [DoctorAuthController::class, 'register']);
    Route::post('/v1/login', [DoctorAuthController::class, 'login']);
    Route::post('/v1/logout', [DoctorAuthController::class, 'logout']);
    Route::post('/v1/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/v1/reset-password', [ForgotPasswordController::class, 'resetPassword']);

    // get All patient locations
    Route::prefix('geolocation')->group(function () {
        Route::get('/patient/all', [GeolocationController::class, 'getAllPatientLocation']);
    });

    // Get Patients for Daftar Pasien
    Route::get('/patients', [PatientProfileController::class, 'getListPatient']);

    // Get Patient photo
    Route::get('/patient/photo', [MonitoringController::class, 'getPatientPhoto']);

    // Get Patient Monitoring Total and Current Time
    Route::get('/patient/monitoring', [MonitoringController::class, 'getPatientMonitoringTotalAndCurrentTime']);

    // Get Patient Current Data Sensor
    Route::get('/patient/sensor', [MonitoringController::class, 'getCurrentSpo2AndBpm']);

    // Get Patient Current Location by Id
    Route::get('/patient/location', [MonitoringController::class, 'getPatientLocationById']);

    // Get Patient Medical Records
    Route::get('/patient/records', [MonitoringController::class, 'getMedicalRecords']);

    // * Detail Rekam Medis
    Route::get('/patient', [MonitoringController::class, 'getDetailMedicalRecordBio']);

    // Get Oximetry Data
    Route::get('/patient/pulse', [MonitoringController::class, 'getOximetryData']);

    // Get Patient Close Contact By id
    Route::get('/patient/contact', [MonitoringController::class, 'getPatientCloseContactById']);

    // Delete Medical Record By id
    Route::delete('/record/delete', [MonitoringController::class, 'deletePatientMedicalRecordById']);

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

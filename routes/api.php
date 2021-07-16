<?php

use App\Http\Controllers\Api\CloseContact\CloseContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Patient\PatientAuthApiController;
use App\Http\Controllers\Api\Patient\ApiForgotPasswordController;
use App\Http\Controllers\Api\Patient\PatientProfileController;
use App\Http\Controllers\Api\Patient\PatientDeviceController;
use App\Http\Controllers\Api\Device\PulseOximetryController;
use App\Http\Controllers\Api\MedicalRecord\MedicalRecordController;
use App\Http\Controllers\Api\Notification\NotificationPatientController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**
 * =============================================
 **                 Route Pasien
 * =============================================
 */
Route::prefix('patient')->group(function () {

    /**
     * * Route authentikasi pasien
     */
    Route::post('/v1/register', [PatientAuthApiController::class, 'register']);
    Route::post('/v1/login', [PatientAuthApiController::class, 'login']);
    Route::post('/v1/logout', [PatientAuthApiController::class, 'logout']);
    Route::post('/v1/forgot-password', [ApiForgotPasswordController::class, 'forgotPassword']);
    Route::post('/v1/reset-password', [ApiForgotPasswordController::class, 'resetPassword']);

    /**
     * * Route get biodata Pasien
     */
    Route::get('/bio', [PatientProfileController::class, 'getBiodata']);

    /**
     * * Route medical record
     */
    Route::prefix('record')->group(function () {
        Route::get('/', [MedicalRecordController::class, 'getMedicalRecord']);
    });


    /**
     * * Route get monitoring result
     */
    Route::prefix('monitoring')->group(function () {
        Route::get('/', [MedicalRecordController::class, 'getMonitoringResult']);
    });


    /**
     * * Route Group Pasien
     */
    Route::group(['middleware' => 'auth:patientapi'], function () {

        /**
         * * Route biodata pasien
         */
        Route::post('/update', [PatientProfileController::class, 'update']);
        // ! update geolokasi sementara
        Route::post('/geo-update', [PatientProfileController::class, 'updatePatientLocation']);

        // TODO : Perlu perbaikan, data terlalu besar belum dioptimalkan
        Route::post('/add-profile-photo', [PatientProfileController::class, 'saveUserProfile']);
        Route::post('/user-profile', [PatientProfileController::class, 'getUserPhoto']);


        /**
         * * Route setup device sebelum digunakan
         */
        Route::prefix('hardware')->group(function () {
            Route::post('/create', [PatientDeviceController::class, 'savePatientDevice']);
            Route::post('/enable', [PatientDeviceController::class, 'enableDevice']);
            Route::post('/disable', [PatientDeviceController::class, 'disableDevice']);
            Route::post('/serial-number', [PatientDeviceController::class, 'getSerialNmber']);
        });



        /**
         * * Route Token Firebase untuk dan menerima notifikasi berdasarkan API Token Firebase
         */
        Route::prefix('token')->group(function () {
            Route::post('/v1/update', [NotificationPatientController::class, 'updateApiToken']);
            Route::post('/v1/delete', [NotificationPatientController::class, 'deleteApiToken']);
        });


        /**
         * * Route topik notifikasi
         */
        Route::prefix('topic')->group(function () {
            Route::post('/update', [NotificationPatientController::class, 'updateTopic']);
            Route::post('/topics', [NotificationPatientController::class, 'getTopics']);
            Route::post('/delete', [NotificationPatientController::class, 'deleteTopic']);
        });


        /**
         * * Route mengisi kontak erat
         */
        Route::prefix('kontak')->group(function () {
            Route::post('/insert', [CloseContactController::class, 'storeCloseContact']);
        });
    });
});



/**
 * =============================================
 **             Route Pulse Oximetry
 * =============================================
 */
Route::prefix('oximetry')->group(function () {
    Route::post('/insert', [PulseOximetryController::class, 'storeDataSensor']);
    Route::get('/data', [PulseOximetryController::class, 'getDataSensor']);
});

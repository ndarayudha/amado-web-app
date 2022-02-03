<?php

use App\Http\Controllers\ApiWeb\DoctorAuthController;
use App\Http\Controllers\ApiWeb\DoctorProfileController;
use App\Http\Controllers\ApiWeb\ForgotPasswordController;
use App\Http\Controllers\Api\Patient\PatientProfileController;
use App\Http\Controllers\Api\Geolocation\GeolocationController;
use App\Http\Controllers\KonfrimasiController;
use App\Http\Controllers\MailAwsController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\SensorController;
use Illuminate\Support\Facades\Route;


Route::get('/mail', function () {
    // return view('mail.isolasi-mandiri');
    return view('mail.rawat-inap');
});

Route::prefix('oksigen')->group(function () {
    Route::get('/', [MonitoringController::class, 'getCurrentOksigen']);
    Route::post('/insert', [MonitoringController::class, 'tambahKapasitasOksigenRumahSakit']);
    Route::post('/kurangi', [MonitoringController::class, 'kurangiKapasitasOksigenRumahSakit']);
});

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

    // Save Penanganan
    Route::post('/penanganan/insert', [MonitoringController::class, 'insertRiwayatPenanganan']);

    // get biodata dokter
    Route::get('/bio', [DoctorProfileController::class, 'getBiodata']);

    Route::group(['middleware' => 'auth:doctor-api'], function () {

        // * Update Biodata
        Route::post('/update', [DoctorProfileController::class, 'update']);

        // * Get Patient Confirm Notification
        Route::prefix('/notification')->group(function () {
            Route::get('/patient', [MonitoringController::class, 'getPatientConfirmNotification']);
            Route::post('/read', [MonitoringController::class, 'readNotification']);
        });

        // * Update Foto Profil
        Route::post('/add-profile-photo', [DoctorProfileController::class, 'saveUserProfile']);

        // * Ambil Foto Profile
        Route::post('/user-profile', [DoctorProfileController::class, 'getUserPhoto']);
    });
});

// Konfimasi
Route::prefix('konfirmasi')->group(function () {
    Route::get('/patient', [KonfrimasiController::class, 'getPatientById']);
});

// Mail Google
// Konfimasi
// Route::prefix('mail')->group(function () {
//     Route::get('/send', [MailController::class, 'send']);
//     Route::get('/access_token', [MailController::class, 'getAccessToken']);
//     Route::post('/konfirmasi', [MailController::class, 'sendKonfirmasiEmail']);
// });

// Mail AWS
Route::prefix('mail')->group(function () {
    Route::post('/konfirmasi', [MailAwsController::class, 'sendKonfirmasiEmail']);
});


// Statistik
Route::prefix('statistik')->group(function () {
    Route::get('/count', [MonitoringController::class, 'getCountModel']);
    Route::get('/patient', [MonitoringController::class, 'getCurrentPatient']);
});


// Get Data Sensor By Id
Route::prefix('/sensor')->group(function () {
    Route::get('/', [SensorController::class, 'getSensorDataById']);
    Route::get('/code', [SensorController::class, 'getLastMonitoringCode']);
    Route::get('/detail', [SensorController::class, 'getDetailSensorDataAndroid']);
    Route::get('/records', [SensorController::class, 'getDetailSensorDataRecords']);
});


// records
Route::prefix('/records')->group(function () {
    Route::post('/upload', function() {
        return response()->json([
            'code' => 200,
            'pesan' => 'konfirmasi berhasil'
        ]); 
    });
    Route::post('/konfirmasi', [SensorController::class, 'konfirmasiRekamMedis']);
    Route::post('/konfirmasi/mail', [MailAwsController::class, 'emailKonfirmasiRekamMedis']);
});

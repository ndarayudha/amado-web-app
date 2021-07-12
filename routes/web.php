<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\Web\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * TODO : Nanti route disesuaikan dengan Laravel 8
 */

Route::get('/', [ClientController::class, 'index'])->name('home');
Route::view('/tech', 'client.layout.tech');

Route::middleware('auth')->group(function () {
	Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
	Route::view('/setting', 'setting')->name('setting')->middleware('can:isAdmin');

	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

	Route::post('/user/datatables', [UserController::class, 'datatables'])->name('user.datatables')->middleware('can:isAdmin');

	Route::prefix('patient')->name('patient.')->group(function () {
		Route::post('/datatables', [PatientController::class, 'datatables'])->name('datatables');
		Route::post('/search', [PatientController::class, 'search'])->name('search');
	});

	Route::prefix('record')->name('record.')->group(function () {
		Route::post('/datatables', [MedicalRecordController::class, 'datatables'])->name('datatables');
		Route::post('/search', [MedicalRecordController::class, 'search'])->name('search');
		Route::get('/print-pdf', [MedicalRecordController::class, 'printPdf'])->name('print-pdf');
		Route::get('/print-excel/{id}', [MedicalRecordController::class, 'exportOxygenExel'])->name('print-excel');
	});


	Route::prefix('member')->name('member.')->group(function () {
		Route::post('/datatables', [MemberController::class, 'datatables'])->name('datatables');
		Route::post('/search', [MemberController::class, 'search'])->name('search');
	});


	Route::resource('patient', PatientController::class);
	Route::resource('record', MedicalRecordController::class);
	Route::resource('lokasi', LokasiController::class);
	Route::resource('user', UserController::class, ['except' => ['show']])->middleware('can:isAdmin');
});

Route::middleware('guest')->group(function () {
	Route::view('/login', 'auth.login')->name('login');
});


/**
 * * Route Notification
 */
// Route::get('/topic-send', [NotificationController::class, 'sendTopicNotification']);
// Route::get('/token-send', [NotificationController::class, 'sendApiTokenNotification']);

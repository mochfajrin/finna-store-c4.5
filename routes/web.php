<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\PelamarController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminRedirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/actionLogin', [AuthController::class, 'actionLogin'])->name('actionLogin');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/actionRegister', [AuthController::class, 'store'])->name('actionRegister');
Route::get('/about', AboutController::class)->name('about');
Route::get('/lowongan', LowonganController::class)->name('lowongan.index');
Route::get("/lowongan/{lowonganId}", [LowonganController::class, "show"])->name('lowongan.show');

Route::middleware('auth')->group(function () {
    Route::get('/users/logout', [AuthController::class, 'logout'])->name('logout');
    Route::middleware(AdminRedirect::class)->group(function () {
        Route::get('/users', UserController::class)->name('user.index');
        Route::post('/users/update', [UserController::class, 'update'])->name('user.update');
        Route::get('/users/notifications', [UserController::class, 'notifications'])->name('user.notifications');
        Route::get('/users/notification/{notification:id}', [UserController::class, 'showNotification'])->name('user.show-notifications');
        Route::get("/lamaran/{lowongan:id}", [PelamarController::class, "registerForm"])->name('pelamar.form');
        Route::post("/lamaran/{lowonganId}", [PelamarController::class, "register"])->name('pelamar.register');
        Route::get('/lamaran/mail/{encryptedPayload}', [PelamarController::class, 'checkMailPage'])->name('pelamar.mail');
        Route::get("/test/{encryptedPayload}", [PelamarController::class, 'testForm'])->name("pelamar.blind-test");
        Route::post("/test/store", [PelamarController::class, 'testSubmit'])->name("pelamar.test-submit");
        Route::get('thanks', function () {
            return view('pelamar.thankyou');
        })->name('thanks');
        Route::get('/admin/model', ModelController::class)->name('model.index');
    });
});

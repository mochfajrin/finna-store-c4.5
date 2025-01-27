<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LowonganController;
use App\Http\Controllers\PelamarController;
use App\Mail\SendTestMail;
use Illuminate\Support\Facades\Mail;
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
Route::get('/about', AboutController::class)->name('about');
Route::get('/lowongan', LowonganController::class)->name('lowongan.index');
Route::get("/lowongan/{lowonganId}", [LowonganController::class, "show"])->name('lowongan.show');
Route::get("/lamaran/{lowongan:id}", [PelamarController::class, "registerForm"])->name('pelamar.form');
Route::post("/lamaran/{lowonganId}", [PelamarController::class, "register"])->name('pelamar.register');
Route::get('/lamaran/mail/{encryptedPayload}', [PelamarController::class, 'checkMailPage'])->name('lamaran.mail');
Route::get('/lamaran/test/{encryptedPayload}', [PelamarController::class, 'test'])->name('lamaran.test  ');
Route::get("/quiz", function () {
    return view("pelamar.color-blind-test");
});

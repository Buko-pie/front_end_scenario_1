<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailVerificationController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/apply', [EmailVerificationController::class, 'apply'])->name('apply');
Route::get('/register', [EmailVerificationController::class, 'register'])->name('register_from');
Route::post('/register_from_send', [EmailVerificationController::class, 'register_from_send'])->name('register_from_send');
Route::post('/submit_email_code', [EmailVerificationController::class, 'submit_email_code'])->name('submit_email_code');

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

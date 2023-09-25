<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Password;
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

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register',[\App\Http\Controllers\AuthController::class, 'register']);
Route::get('/getUser', [\App\Http\Controllers\AuthController::class, 'getUser'])
    ->middleware('auth');
Route::get('/email/verify', function () {
    return view('auth.verify-email');}) // do to fronta
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
})->middleware('signed','auth')->name('verification.verify');

Route::post('/forgotPassword', [\App\Http\Controllers\AuthController::class, 'emailPasswordReset'])
    ->name('password.email');
Route::get('/resetPassword/{token}', function (string $token) {
    return ['token' => $token];
})->middleware('guest')->name('password.reset');
Route::post('/resetPassword',[\App\Http\Controllers\AuthController::class, 'resetPassword']);
Route::get('/logout',[\App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth');

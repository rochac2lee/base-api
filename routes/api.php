<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

// Route::group(['namespace' => 'App\Http\Controllers\Users'], function () {
//     Route::post('register', 'AuthController@signup')->name('register');
//     Route::post('auth/login', 'AuthController@login')->name('login');
// });

// Route::post('register', 'AuthController@signup')->name('register');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('auth')->withoutMiddleware('auth:sanctum')->group(function () {
        $limiter = config('fortify.limiters.login');

        Route::post('login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest:' . config('fortify.guard'),
                $limiter ? 'throttle:' . $limiter : null,
            ]));

        // Registration
        Route::post('register', [RegisteredUserController::class, 'store'])
            ->middleware('guest:' . config('fortify.guard'));
    });

    // Reset Password
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:' . config('fortify.guard'));
        
    // Users
    Route::resource('users', UserController::class);
});

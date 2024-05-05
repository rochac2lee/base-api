<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers\Users'], function () {
    Route::post('register', 'AuthController@signup')->name('register');
    Route::post('auth/login', 'AuthController@login')->name('login');
});
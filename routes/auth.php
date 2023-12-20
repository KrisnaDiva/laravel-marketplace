<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function(){
    Route::get('/login',[LoginController::class,'create'])->name('login');
    Route::post('/login',[LoginController::class,'store'])->name('login.process');
    Route::get('/register',[RegisterController::class,'create'])->name('register');
    Route::post('/register',[RegisterController::class,'store'])->name('register.process');

    Route::controller(PasswordController::class)->group(function(){
        Route::get('/forgot-password','request')->name('password.request');
        Route::post('/forgot-password','email')->name('password.email');
        Route::get('/reset-password/{token}','reset')->name('password.reset');
        Route::post('reset-password','store')->name('password.store');
    });
});

Route::middleware('auth')->group(function(){
    Route::controller(EmailVerificationController::class)->prefix('/verify-email')->group(function(){
        Route::get('','notice')->name('verification.notice');
        Route::post('','store')->middleware('throttle:6,1')->name('verification.send');
        Route::get('/{id}/{hash}','verify')->middleware(['signed', 'throttle:6,1'])->name('verification.verify');       
    });
    
    Route::delete('/logout',[LogoutController::class,'destroy'])->name('logout');
});
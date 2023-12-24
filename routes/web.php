<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\WishlistController;
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

Route::middleware(['auth','verified'])->group(function(){
    Route::controller(ProfileController::class)->prefix('/profile')->group(function(){
        Route::get('','edit')->name('profile.edit');
        Route::patch('','update')->name('profile.update');
        Route::delete('','destroy')->name('profile.destroy');
    });    
        Route::patch('/update-password',[PasswordController::class,'update'])->name('password.update');
        Route::get('/',[DashboardController::class,'index'])->name('dashboard');
        Route::get('/products/{product}',[ProductController::class,'show'])->name('products.show');
});

require __DIR__.'/auth.php';
require __DIR__.'/store.php';

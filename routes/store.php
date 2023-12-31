<?php

use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\StoreAddressController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth','verified'])->prefix('/store')->group(function(){
    Route::middleware(['hasStore'])->group(function (){
        Route::get('',[StoreController::class,'index'])->name('store.index');     
        Route::get('/{store}/edit',[StoreController::class,'edit'])->name('store.edit');
        Route::patch('/{store}',[StoreController::class,'update'])->name('store.update');
        Route::put('/{address}',[StoreAddressController::class,'update'])->name('store.updateAddress');
        Route::resource('products',ProductController::class)->except(['show']);
        Route::delete('products/{product}/images/{image}',[ProductController::class,'destroyImage'])->name('products.destroyImage');
        Route::get('/order/{hasPaid}',[OrderController::class,'index'])->name('order.index');
    });


    
    Route::middleware(['hasntStore'])->group(function (){
        Route::get('/onboarding',[StoreController::class,'onboardingIndex'])->name('onboarding.index');
        Route::get('/create',[StoreController::class,'create'])->name('store.create');
        Route::post('',[StoreController::class,'store'])->name('store.store');
    });
       
});




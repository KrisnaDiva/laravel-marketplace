<?php

use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\StoreController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth','verified'])->prefix('/store')->group(function(){
    Route::middleware(['hasStore'])->group(function (){
        Route::get('',[StoreController::class,'index'])->name('store.index');     
        Route::get('/{store}/edit',[StoreController::class,'edit'])->name('store.edit');
        Route::patch('/{store}',[StoreController::class,'update'])->name('store.update');
        Route::resource('products',ProductController::class);
  
    });


    
    Route::middleware(['hasntStore'])->group(function (){
        Route::get('/onboarding',[StoreController::class,'onboardingIndex'])->name('onboarding.index');
        Route::get('/create',[StoreController::class,'create'])->name('store.create');
        Route::post('',[StoreController::class,'store'])->name('store.store');
    });
       
});




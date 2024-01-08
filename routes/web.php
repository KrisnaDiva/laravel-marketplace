<?php

use App\Http\Controllers\Address\CityController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\WishlistController;
use App\Models\UserAddress;
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

        Route::controller(CartController::class)->prefix('/cart')->group(function (){
            Route::get('','index')->name('cart.index');
            Route::post('/{product}','store')->name('cart.store');
        });
        Route::controller(CartItemController::class)->prefix('/cartItem')->group(function (){
            Route::delete('/{cartItem}','destroy')->name('cartItem.destroy');
            Route::patch('/increment/{cartItem}','increment')->name('cartItem.increment');
            Route::patch('/decrement/{cartItem}','decrement')->name('cartItem.decrement');
        });
        Route::patch('address/setMain/{userAddress}',[UserAddressController::class,'setMain'])->name('address.setMain');
        Route::patch('address/setMain/',[UserAddressController::class,'setMainWithoutParam'])->name('address.setMainWithoutParam');
        Route::resource('/address',UserAddressController::class);

        Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout')->middleware('hasAddress');
        Route::post('/checkout',[CheckoutController::class,'buyNow'])->name('buyNow')->middleware('hasAddress');
        Route::post('/order',[OrderController::class,'store'])->name('order'); 
        Route::post('/orderr',[OrderController::class,'storeBuyNow'])->name('order.buyNow'); 
        
        Route::get('/my-order/hasPaid',[OrderController::class,'hasPaid'])->name('order.hasPaid');
        Route::get('/my-order/hasntPaid',[OrderController::class,'hasntPaid'])->name('order.hasntPaid');
        Route::get('/my-order/canceled',[OrderController::class,'canceled'])->name('order.canceled');
        Route::delete('/my-order/{order}',[OrderController::class,'destroy'])->name('order.destroy');
        Route::get('/my-order/print/{order}',[OrderController::class,'userPrint'])->name('order.userPrint');
        Route::patch('/payment-success/{order}',[OrderController::class,'paymentSuccess'])->name('order.paymentSuccess');

        Route::get('my-order/{orderDetail}/review',[ReviewController::class,'create'])->name('review.create');
        Route::post('my-order/{orderDetail}/review',[ReviewController::class,'store'])->name('review.store');
        Route::get('my-order/{orderDetail}/review/edit',[ReviewController::class,'edit'])->name('review.edit');
        Route::put('my-order/{orderDetail}/review',[ReviewController::class,'update'])->name('review.update');
        Route::delete('review/{orderDetail}/images/{image}',[ReviewController::class,'destroyImage'])->name('review.destroyImage');

        Route::get('/get-cities/{province}', [CityController::class,'getCities']);
});

require __DIR__.'/auth.php';
require __DIR__.'/store.php';

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CartItem $cartItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        
    }
    public function increment(Request $request, CartItem $cartItem)
    {
        $this->authorize('delete',$cartItem);
        $quantity=$cartItem->quantity;
        $product=$cartItem->product;
        $cartItem->quantity=$quantity+1;
        $cartItem->save();
        $cartItem->price=$cartItem->quantity*$product->price;
        $cartItem->save();
        $cart=Cart::find($cartItem->cart_id);
        $cart->total_price=$cart->cartItems()->sum('price');
        $cart->save();
        session()->flash('success','1 product has been updated.');
    }
    public function decrement(Request $request, CartItem $cartItem)
    {
        $this->authorize('delete',$cartItem);
        $quantity=$cartItem->quantity;
        $product=$cartItem->product;
        $cartItem->quantity=$quantity-1;
        $cartItem->save();
        $cartItem->price=$cartItem->quantity*$product->price;
        $cartItem->save();
        $cart=Cart::find($cartItem->cart_id);
        $cart->total_price=$cart->cartItems()->sum('price');
        $cart->save();
        session()->flash('success','1 product has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartItem $cartItem)
    {
        $this->authorize('delete',$cartItem);
        $cartItem->delete();
        $cart=Cart::find($cartItem->cart_id);
        $cart->total_price=$cart->cartItems()->sum('price');
        $cart->save();
        session()->flash('success','1 product has been removed.');
    }
}

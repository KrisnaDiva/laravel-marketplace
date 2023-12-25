<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<=2;$i++){
            $cartItem=CartItem::create([
                'cart_id'=>$i,
                'product_id'=>mt_rand(1,5),
                'quantity'=>mt_rand(1,5),
            ]);
            $product=Product::find($cartItem->product_id);
            $productPrice=$product->price;
            $cartItem->price=($productPrice*$cartItem->quantity);
            $cartItem->save();
    
            $cartItem=CartItem::create([
                'cart_id'=>$i,
                'product_id'=>mt_rand(6,10),
                'quantity'=>mt_rand(1,5),
            ]);
            $product=Product::find($cartItem->product_id);
            $productPrice=$product->price;
            $cartItem->price=($productPrice*$cartItem->quantity);
            $cartItem->save();
    
            $cart=Cart::find($cartItem->cart_id);
            $cart->total_price=$cart->cartItems()->sum('price');
            $cart->save();
        }
        
    }
}

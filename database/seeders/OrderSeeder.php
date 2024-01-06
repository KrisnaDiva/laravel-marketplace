<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order=Order::Create([
            'shipping_cost'=>1,
            'has_paid'=>1,
            'store_id'=>1,
            'user_id'=>1,
            'address_id'=>1
        ]);
        $product=Product::find(1);
        OrderDetail::create([
            'name'=>$product->name,
            'weight'=>2*$product->weight,
            'quantity'=>2,
            'subtotal'=>111111,
            'order_id'=>$order->id,
            'image_id'=>$product->images->first() ? $product->images->first()->id : null,
            'product_id'=>$product->id
        ]);
        $product=Product::find(3);
        OrderDetail::create([
            'name'=>$product->name,
            'weight'=>3*$product->weight,
            'quantity'=>3,
            'subtotal'=>222222,
            'order_id'=>$order->id,
            'image_id'=>$product->images->first() ? $product->images->first()->id : null,
            'product_id'=>$product->id
        ]);
    }
}

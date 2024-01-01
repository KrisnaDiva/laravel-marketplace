<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
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
            'has_paid'=>0,
            'store_id'=>1,
            'user_id'=>1,
            'address_id'=>1
        ]);
        OrderDetail::create([
            'quantity'=>2,
            'subtotal'=>111111,
            'order_id'=>$order->id,
            'product_id'=>1
        ]);
        OrderDetail::create([
            'quantity'=>3,
            'subtotal'=>222222,
            'order_id'=>$order->id,
            'product_id'=>3
        ]);
    }
}

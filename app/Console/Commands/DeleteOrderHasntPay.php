<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeleteOrderHasntPay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:delete-order-hasnt-pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = now()->subDay();
        
        $ordersToDelete = Order::where('has_paid', 0)
            ->where('created_at', '<', $threshold)->get();
    
        foreach ($ordersToDelete as $order) {
            foreach($order->details as $detail){
                $product=Product::find($detail->product_id);
                $quantity=$detail->quantity;
                $stock=$product->stock;
                $product->stock=$stock+$quantity;
                $product->save();
                $detail->delete();
            }
            $order->delete();
        }
        // $ordersToDelete->delete();
    }
    
}

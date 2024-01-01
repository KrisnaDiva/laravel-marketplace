<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Repositories\UserRepository;
use App\Services\UserAddressService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UserRepository $user, private UserAddressService $userAddress)
    {
    }
    public function index(Request $request,$id)
    {
       
        $user=$this->user->getUser();
        return view('store.order.index',[
            'user'=>$user,
            'orders'=>$user->store->orders->where('has_paid',$id)
        ]); 
    }
    public function hasPaid()
    {
        $user=$this->user->getUser();
        return view('profile.my-order',[
            'user'=>$user,
            'orders'=>$user->orders->where('has_paid',1)
        ]);
    }
    public function hasntPaid()
    {
        $user=$this->user->getUser();
        return view('profile.my-order',[
            'user'=>$user,
            'orders'=>$user->orders->where('has_paid',0)
        ]);
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
        $user = $this->user->getUser();

        $cartInputs = array_filter($request->input(), function ($key) {
            return strpos($key, 'cart') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $costInputs = array_filter($request->input(), function ($key) {
            return strpos($key, 'cost') === 0;
        }, ARRAY_FILTER_USE_KEY);

        $item = [];
        $cost = [];
        $storeItems = [];

        foreach ($cartInputs as $key => $cart) {
            $index = substr($key, 4);
            $item[] = CartItem::find($index);
        }
        
        foreach ($costInputs as $key => $costt) {
            $index = substr($key, 4);
            $cost[$index] = $costt['shippingCost']; 
        }

        foreach ($item as $cartItem) {
            $storeId = $cartItem->product->store_id;
            if (!isset($storeItems[$storeId])) {
                $storeItems[$storeId] = [];
            }
            $storeItems[$storeId][] = $cartItem;
            if (array_key_exists($cartItem->id, $cost)) {
                $storeItems[$storeId]['shippingCost'] = $cost[$cartItem->id];
            }
        }
        
        foreach ($storeItems as $key => $items) {
            $order = Order::create([
                'shipping_cost' => $items['shippingCost'],
                'has_paid'=>1,
                'store_id' => $key,
                'user_id' => $user->id,
                'address_id' => $this->userAddress->getMainAddress()->id
            ]);
            unset($items['shippingCost']);
            foreach ($items as $item) {
                $detail=OrderDetail::create([
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * $item->product->price,
                    'product_id' => $item->product->id,
                    'order_id' => $order->id
                ]);
                $product=Product::find($detail->product_id);
                $quantity=$detail->quantity;
                $stock=$product->stock;
                $product->stock=$stock-$quantity;
                $product->save();
            }
        }
        foreach ($cartInputs as $cart){
            $cart=CartItem::find($cart);
            $cart->delete();
        }
        return redirect()->route('order.hasPaid');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

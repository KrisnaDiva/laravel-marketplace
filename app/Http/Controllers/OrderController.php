<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Repositories\UserRepository;
use App\Services\UserAddressService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UserRepository $user, private UserAddressService $userAddress)
    {
    }
    public function index(Request $request,$id=null)
    {
        $user=$this->user->getUser();
        if ($id !== null) {
            $orders = $user->store->orders->where('has_paid', $id);
        }else{
            $orders=Order::onlyTrashed()
            ->where('store_id', $user->store->id)
            ->where('has_paid', 0)->get();
        }
        return view('store.order.index',[
            'user'=>$user,
            'orders'=>$orders
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
    public function cancel()
    {
        $user=$this->user->getUser();
        return view('profile.my-order',[
            'user'=>$user,
            'orders'=>Order::onlyTrashed()
            ->where('user_id', $user->id)
            ->where('has_paid', 0)->get()
        ]);
    }

    public function userPrint(Order $order)
    {
        
    	$pdf = PDF::loadview('profile.pdf',['order'=>$order]);
        $pdf->setPaper('A4', 'landscape');
    	return $pdf->download('transaction-detail.pdf');
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
            if(!isset($cartItem->product)){
                return redirect()->route('cart.index')->with('error', 'Failed to create order');
            }
            $storeId = $cartItem->product->store_id;
            if (!isset($storeItems[$storeId])) {
                $storeItems[$storeId] = [];
            }
            $storeItems[$storeId][] = $cartItem;
            if (array_key_exists($cartItem->id, $cost)) {
                $storeItems[$storeId]['shippingCost'] = $cost[$cartItem->id];
            }
        }
        
        try{
            DB::beginTransaction();
            foreach ($storeItems as $key => $items) {
                $order = Order::create([
                    'shipping_cost' => $items['shippingCost'],
                    'has_paid'=>0,
                    'store_id' => $key,
                    'user_id' => $user->id,
                    'address_id' => $this->userAddress->getMainAddress()->id
                ]);
                unset($items['shippingCost']);
                foreach ($items as $item) {
                   
                    if ($item->quantity > $item->product->stock) {
                        DB::rollBack();
                        return redirect()->route('cart.index')->with('error', 'Failed to create order');
                    }
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
            DB::commit();
            return redirect()->route('order.hasPaid');
        }catch(QueryException $e){
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Failed to create order: ' . $e->getMessage());
        }
       
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
        $this->authorize('delete',$order);
        foreach($order->details as $detail){
            $product=Product::find($detail->product_id);
            $quantity=$detail->quantity;
            $stock=$product->stock;
            $product->stock=$stock+$quantity;
            $product->save();
        }
        $order->delete();
        return back();
    }
}

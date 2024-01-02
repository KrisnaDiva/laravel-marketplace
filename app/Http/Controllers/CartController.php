<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\UserRepository;
use App\Services\ProductService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(private UserRepository $user,private ProductService $productService){}
    public function index():View
    {
        $user=$this->user->getUser();
        return view('cart',[
            'user'=>$user,
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
    public function store(Request $request,$id)
    {
        try{
            DB::beginTransaction();
            $user=$this->user->getUser();
            $product=$this->productService->getProduct($id);
            if ($product->stock === 0) {
                return back()->with('error', 'Product is out of stock.');
            }
            if(!$user->cart){
                $cart=Cart::create([
                    'user_id'=>$user->id
                ]);
            }else{
                $cart=$user->cart;
            }            
            $cartItem=CartItem::where('cart_id',$cart->id)->where('product_id',$product->id)->first();
            $request->validate([
                'quantity'=>'required',
            ]);
            if($cartItem){
                if(($request->quantity+$cartItem->quantity)>$product->stock){
                    return back()->with('error',"
                    There are $product->stock left in stock for this item and you already have $cartItem->quantity in your basket.");
                }
                    $cartItem->update([
                    'quantity'=>$request->quantity+$cartItem->quantity,
                    ]);
            }else{
                CartItem::create([
                    'cart_id'=>$cart->id,
                    'product_id'=>$product->id,
                    'quantity'=>$request->quantity,
                ]);
            }
            DB::commit();
            return back()->with('success','add to cart success!');
        }catch(QueryException $e){
            DB::rollBack();
        }   
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        
    }
}

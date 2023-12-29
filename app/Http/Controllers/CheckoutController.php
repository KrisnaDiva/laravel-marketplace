<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Repositories\UserRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private UserRepository $user,private ProductService $productService){}
   public function store(Request $request)
{
    $carts = CartItem::whereIn('id', $request->carts)
        ->with('product.store')
        ->get()
        ->groupBy('product.store.id');

    return view('checkout', [
        'user' => $this->user->getUser(),
        'groupedCarts' => $carts,
    ]);
}

//     public function store(Request $request)
// {
//     $cartItems = CartItem::find($request->carts);

//     // Group cart items by store ID
//     $groupedCarts = $cartItems

//     return view('checkout', [
//         'user' => $this->user->getUser(),
//         'groupedCarts' => $groupedCarts,
//     ]);
// }
}

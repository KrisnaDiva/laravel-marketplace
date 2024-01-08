<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Repositories\UserRepository;
use App\Services\ProductService;
use App\Services\UserAddressService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private UserRepository $user, private ProductService $productService, private UserAddressService $userAddressService)
    {
    }
    public function index(Request $request)
    {
        $carts = CartItem::whereIn('id', $request->carts)
            ->with('product.store')
            ->get()
            ->groupBy('product.store.id');

        $user = $this->user->getUser();
        return view('checkout', [
            'user' => $user,
            'groupedCarts' => $carts,
            'addresses' => $user->addresses,
            'mainAddress' => $this->userAddressService->getMainAddress()
        ]);
    }
    public function buyNow(Request $request)
    {
        $user = $this->user->getUser();
        return view('buy-now', [
            'user' => $user,
            'product' =>Product::find($request->product_id),
            'quantity'=>$request->quantity,
            'addresses' => $user->addresses,
            'mainAddress' => $this->userAddressService->getMainAddress()
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

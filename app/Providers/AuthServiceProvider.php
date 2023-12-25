<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\Store;
use App\Policies\CartItemPolicy;
use App\Policies\CartPolicy;
use App\Policies\ProductPolicy;
use App\Policies\StorePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Store::class => StorePolicy::class,
        Product::class => ProductPolicy::class,
        CartItemPolicy::class=>CartItem::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

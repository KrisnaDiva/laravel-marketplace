<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
        ->when($filters['sortBy'] ?? false, function ($query, $sortBy) use ($filters) {
            if ($sortBy == 'price') {
                return $query->orderBy('price', $filters['order'] ?? 'asc');
            }elseif ($sortBy == 'sales') {
                return $query
                    ->withCount(['orderDetails as total_sales' => function ($subQuery) {
                        $subQuery->join('orders', 'order_details.order_id', '=', 'orders.id')
                            ->where('orders.has_paid', 1);
                    }])
                    ->orderBy('total_sales', $filters['order'] ?? 'desc');
            } elseif ($sortBy == 'desc') {
                return $query->orderBy('created_at', 'desc');
            }
        });
    }

    protected $guarded=['id'];
    public function store():BelongsTo{
        return $this->belongsTo(Store::class);
    }
    public function category():BelongsTo{
        return $this->belongsTo(Category::class);
    }
    public function condition():BelongsTo{
        return $this->belongsTo(ProductCondition::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class,'product_images')->withPivot(["created_at","updated_at"]);
    }
    public function cartItems():HasMany{
        return $this->hasMany(CartItem::class,'product_id','id');
    }
    public function orderDetails():HasMany{
        return $this->hasMany(OrderDetail::class,'product_id','id');
    }
  
}

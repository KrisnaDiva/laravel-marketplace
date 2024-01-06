<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function store():BelongsTo{
        return $this->belongsTo(Store::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_images')->withPivot(["created_at","updated_at"]);
    }
    public function reviews()
    {
        return $this->belongsToMany(Review::class,'review_images')->withPivot(["created_at","updated_at"]);
    }
    public function details():HasMany{
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function order():BelongsTo{
        return $this->belongsTo(Order::class);
    }
    public function product():BelongsTo{
        return $this->belongsTo(Product::class);
    }
    public function productWithTrashed():BelongsTo{
        return $this->belongsTo(Product::class,'product_id','id')->withTrashed();
    }
    public function review():HasOne{
        return $this->hasOne(Review::class,'detail_id','id');
    }
    public function image():BelongsTo{
        return $this->belongsTo(Image::class);
    }
}

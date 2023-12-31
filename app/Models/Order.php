<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function details():HasMany{
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function store():BelongsTo{
        return $this->belongsTo(Store::class);
    }
    public function address():BelongsTo{
        return $this->belongsTo(UserAddress::class);
    }
}

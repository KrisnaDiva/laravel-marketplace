<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory,SoftDeletes;
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
    public function addressWithTrashed():BelongsTo{
        return $this->belongsTo(UserAddress::class,'address_id','id')->withTrashed();
    }
}

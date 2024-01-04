<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function orderDetail():BelongsTo{
        return $this->belongsTo(OrderDetail::class);
    }
    public function rating():BelongsTo{
        return $this->belongsTo(Rating::class);
    }
}

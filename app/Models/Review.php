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
        return $this->belongsTo(OrderDetail::class,'detail_id','id');
    }
    public function rating():BelongsTo{
        return $this->belongsTo(Rating::class);
    }
    public function images()
    {
        return $this->belongsToMany(Image::class,'review_images')->withPivot(["created_at","updated_at"]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Store extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function store():BelongsTo{
        return $this->belongsTo(Store::class);
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function image():HasOne{
        return $this->hasOne(Image::class,'id', 'image_id');
    }
    public function products():HasMany{
        return $this->hasMany(Product::class);
    }
}

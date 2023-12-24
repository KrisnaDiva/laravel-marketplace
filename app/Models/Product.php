<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
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
  
}

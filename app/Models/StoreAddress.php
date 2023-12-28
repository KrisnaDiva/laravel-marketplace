<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StoreAddress extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function store():BelongsTo{
        return $this->belongsTo(Store::class);
    }
    public function province():BelongsTo{
        return $this->belongsTo(Province::class);
    }
    public function city():BelongsTo{
        return $this->belongsTo(City::class);
    }
}

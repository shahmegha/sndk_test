<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;

class ProductImage extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','is_thumbnail'];
    /**
     * Get the product that owns the attributes.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

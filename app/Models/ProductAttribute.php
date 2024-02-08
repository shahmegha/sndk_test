<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Product;
class ProductAttribute extends Model
{
    use HasFactory;
    
    protected $fillable = ['size','price','product_id'];
    
    /**
     * Get the product that owns the attributes.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

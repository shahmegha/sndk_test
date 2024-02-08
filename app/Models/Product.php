<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','category_id','sub_category_id','regular_price'];
    
    /**
     * Get the images for the product.
     */
    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
    
    /**
     * Get the attributes for the product.
     */
    public function productAttributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }
}

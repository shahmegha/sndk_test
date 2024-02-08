<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','parent_category_id']; 
    
    /**
     * Get the images for the product.
     */
    public function subCategory(): HasMany
    {
        return $this->hasMany(Category::class,'parent_category_id','id');
    }
    
    public function getSubCategoryName() 
    {
        $subCategory= $this->subCategory()->pluck('name');
        $subArray = [];
        foreach ($subCategory as $sub) {
            $subArray[] = $sub;
        }
        return implode(",",$subArray);
    }
}

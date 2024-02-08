<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductImage;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class ProductController extends Controller
{
    /**
     * Display all categories
     * @return View
     */
    public function index() : View
    {
        $products = Product::latest()->paginate(5);
        return view('admin.product.index',compact('products'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Display add or edit form for category add
     * @return View
     */
    public function add(int|null $productId = null) : View
    {
        $catObj = Category::whereNull('parent_category_id');
        if(!empty($productId)){
            $catObj->where('id','!=',$productId);
        }
        $categories = $catObj->get();
        $subCategories = Category::whereNotNull('parent_category_id')->get();
        $mode = 'add';
        $product = null;
        if(!empty($productId)){
            $product = Product::findOrFail($productId);
            $mode = 'edit';
        }
        return view('admin.product.add',[
            'categories'=>$categories,
            'sub_categories'=>$subCategories,
            'mode'=>$mode,
            'product'=>$product
            ]);
    }
    
    /**
     * Update the category information.
     */
    public function update(ProductRequest $request): RedirectResponse
    {
        $mode = $request->mode;
        if($mode == 'edit' && !empty($request->id)){
            $product = Product::findOrFail($request->id);
            
        }else{
            $product = new Product();
        }
        $product->name = $request->product_name;
        $product->category_id = (!empty($request->category_id))?(int)$request->category_id:null;
        $product->sub_category_id = (!empty($request->sub_category_id))?(int)$request->sub_category_id:null;
        $product->regular_price = (!empty($request->regular_price))?$request->regular_price:0;
        
        $productImages = [];
        $productThumbnail = '';
        if ($request->file('product_images')){
            $basePath = public_path('uploads').DIRECTORY_SEPARATOR.'products';
            $originalPath = $basePath.DIRECTORY_SEPARATOR.'original';
            $thumbnailPath = $basePath.DIRECTORY_SEPARATOR.'thumbnail';
            foreach($request->file('product_images') as $key => $file)
            {
                $fileName = time() .'_'. md5($file->getClientOriginalName()) .'.'. $file->getClientOriginalExtension();
                $file->move($originalPath, $fileName);
                
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());

                // read image from file system
                $image = $manager->read($originalPath.DIRECTORY_SEPARATOR.$fileName);

                // resize image proportionally to 300px width
                $image->scale(width: 50);

                // save modified image in new format 
                $image->toPng()->save($thumbnailPath.DIRECTORY_SEPARATOR.$fileName);
                
                $productImage['name'] = $fileName;
                $productImage['is_thumbnail'] = ($key == 0 && $mode == 'add')?true:false;
                $productImages[] = $productImage;
                
                if(($key == 0 && $mode == 'add')){
                    $productThumbnail = $fileName;
                }
            }
        }
        if(!empty($productThumbnail)){
            $product->product_thumbnail = $productThumbnail;
        }
        $product->save();
        
        $productId = $product->id;
        
        //Delete product image which is delete
        if(!empty($request->product_image_delete)){
            $imageToDelete = explode(",",$request->product_image_delete);
            if(!empty($imageToDelete)){
                ProductImage::whereIn('id',$imageToDelete)->delete();
            }
        }
                
        //Save product image in table
        if(!empty($productImages)){
            $product->productImages()->createMany($productImages);
        }
        //Delete product attributes which is delete
        if(!empty($request->product_attribute)){
            $attrIds = array_filter(array_unique(array_column($request->product_attribute, 'id')));
            if(!empty($attrIds)){
                ProductAttribute::whereNotIn('id',$attrIds)->delete();
            }
        }
        //Save product attribute
        if(!empty($request->product_attribute)){
            $productAttributes = [];
            foreach($request->product_attribute as $attr){
                if(!empty($attr['id'])){
                    $productAttribute = ProductAttribute::findOrFail($attr['id']);
                }else{
                    $productAttribute = new ProductAttribute($attr);
                }
                $productAttribute->size = $attr['size'];
                $productAttribute->price = $attr['price'];
                $productAttributes[] = $productAttribute;
            }
            $product->productAttributes()->saveMany($productAttributes);
        }
        return Redirect::route('admin.product.index')->with('success', 'Product saved succefully.');
        //return Redirect::route('admin.product.edit',$productId)->with('success', 'Product saved succefully.');
    }
    
    public function destroy($product_id): RedirectResponse
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return redirect()->route('admin.product.index')
                        ->with('success','Product deleted successfully');
    }
}

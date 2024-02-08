<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display all categories
     * @return View
     */
    public function index() : View
    {
        $categories = Category::whereNull('parent_category_id')->latest()->paginate(5);
        return view('admin.category.index',compact('categories'))
                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    /**
     * Display add or edit form for category add
     * @return View
     */
    public function add(int|null $category_id = null) : View
    {
        $categories = Category::whereNull('parent_category_id')->get();
        $mode = 'add';
        $category = null;
        if(!empty($category_id)){
            $category = Category::findOrFail($category_id);
            $mode = 'edit';
        }
        return view('admin.category.add',[
            'categories'=>$categories,
            'mode'=>$mode,
            'category'=>$category
            ]);
    }
    
    /**
     * Update the category information.
     */
    public function update(CategoryRequest $request): RedirectResponse
    {
        $mode = $request->mode;
        $category_id = $request->id;
        if($mode == 'edit' && !empty($category_id)){
            $category = Category::findOrFail($category_id);
            $category->name = $request->category_name;
            $category->parent_category_id = $request->parent_category_id;
            $category->save();
        }else{
            $category = Category::create([
                'name'=>$request->category_name,
                'parent_category_id'=>(!empty($request->parent_category_id))?(int)$request->parent_category_id:null
            ]);
            $category_id = $category->id;
        }
        return Redirect::route('admin.category.index')->with('success', 'Category saved succefully.');
        //return Redirect::route('admin.category.edit',$category_id)->with('success', 'Category saved succefully.');
    }
    
    public function destroy($category_id): RedirectResponse
    {
        $category = Category::findOrFail($category_id);
        $category->delete();
        return redirect()->route('admin.category.index')
                        ->with('success','Category deleted successfully');
    }
}

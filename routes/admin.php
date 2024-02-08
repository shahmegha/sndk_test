<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;

Route::middleware('admin')->prefix('admin')->group(function () {
    //Dashboard 
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    //Category
    Route::get('category', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('category/add', [CategoryController::class, 'add'])->name('admin.category.add');
    Route::post('category/update', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('category/edit/{id}', [CategoryController::class, 'add'])->name('admin.category.edit');
    Route::post('category/destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    
    //Product
    Route::get('product', [ProductController::class, 'index'])->name('admin.product.index');
    Route::get('product/add', [ProductController::class, 'add'])->name('admin.product.add');
    Route::post('product/update', [ProductController::class, 'update'])->name('admin.product.update');
    Route::get('product/edit/{id}', [ProductController::class, 'add'])->name('admin.product.edit');
    Route::post('product/destroy/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
});
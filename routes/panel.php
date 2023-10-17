<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('panel.index');
});

Route::resource('/products', ProductController::class)->names('product');

Route::resource('/categories', CategoryController::class)->names('category');
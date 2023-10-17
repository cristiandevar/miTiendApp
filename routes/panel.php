<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('panel.index');
});

Route::resource('/products', ProductController::class)->names('product');
 
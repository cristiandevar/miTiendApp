<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Auth;

Route::resource('/products', ProductController::class)->names('product');

Route::resource('/categories', CategoryController::class)->names('category');

Route::resource('/suppliers', SupplierController::class)->names('supplier');

Route::resource('/employees', EmployeeController::class)->names('employee');

Route::get('/', [HomeController::class, 'index'])->name('panel');
Route::get('/home', [HomeController::class, 'index']);


// Route::get('/', function () {
//     if (Auth::check()) {
//         return view('panel.index');
//     } else {
//         return redirect('web.home');
//     }
// });
<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SupplierController;


// Rutas para el CRUD de productos
Route::resource('/products', ProductController::class)->names('product');
// Ruta para filtro de productos
Route::get('/products-filter', [App\Http\Controllers\ProductController::class, 'filter'])->name('product.filter');
Route::get('/products-filter-price', [App\Http\Controllers\ProductController::class, 'filter_price'])->name('product.filter-price');
Route::get('/products-filter-async', [App\Http\Controllers\ProductController::class, 'filter_async'])->name('product.filter-async');
Route::get('/products-filter-price-update', [App\Http\Controllers\ProductController::class, 'update_price'])->name('product.update-price');
Route::post('/products-filter-price-update-async', [App\Http\Controllers\ProductController::class, 'update_price_async'])->name('product.update-price-async');
Route::get('/products-query-price', [App\Http\Controllers\ProductController::class, 'query_price'])->name('product.query-price');
Route::get('/products-query-price-async', [App\Http\Controllers\ProductController::class, 'query_price_async'])->name('product.query-price-async');
// Ruta para exportar archivos
Route::get('/products-export-file', [App\Http\Controllers\ProductController::class, 'export_file'])->name('products.export-file'); 

// Rutas para el CRUD de categorias
Route::resource('/categories', CategoryController::class)->names('category');

// Rutas para el CRUD de proveedores
Route::resource('/suppliers', SupplierController::class)->names('supplier');

// Rutas para el CRUD de empleados
Route::resource('/employees', EmployeeController::class)->names('employee');



// Rutas para redirigir al login o al panel segun corresponda
Route::get('/', [HomeController::class, 'index'])->name('panel');
Route::get('/home', [HomeController::class, 'index']);


// Rutas para CRUD ventas
Route::resource('/sales', SaleController::class)->names('sale');


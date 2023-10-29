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
Route::get('/products/filter', [ProductController::filter])->name('product.filter');


// Rutas para el CRUD de categorias
Route::resource('/categories', CategoryController::class)->names('category');

// Rutas para el CRUD de proveedores
Route::resource('/suppliers', SupplierController::class)->names('supplier');

// Rutas para el CRUD de empleados
Route::resource('/employees', EmployeeController::class)->names('employee');



// Rutas para redirigir al login o al panel segun corresponda
Route::get('/', [HomeController::class, 'index'])->name('panel');
Route::get('/home', [HomeController::class, 'index']);


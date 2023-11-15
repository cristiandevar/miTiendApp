<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;


// Rutas para el CRUD de productos
Route::resource('/products', ProductController::class)->names('product');

// Rutas para el CRUD de categorias
Route::resource('/categories', CategoryController::class)->names('category');

// Rutas para el CRUD de proveedores
Route::resource('/suppliers', SupplierController::class)->names('supplier');

// Rutas para el CRUD de empleados
Route::resource('/employees', EmployeeController::class)->names('employee');

// Rutas para CRUD ventas
Route::resource('/sales', SaleController::class)->names('sale');

// Rutas para CRUD compras
Route::resource('/purchases', PurchaseController::class)->names('purchase');



// Rutas para redirigir al login o al panel segun corresponda
Route::get('/', [HomeController::class, 'index'])->name('panel');
Route::get('/home', [HomeController::class, 'index']);

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

// Ruta para registrar venta y sus detalles
Route::get('/sales-register-index', [SaleController::class, 'register_index'])->name('sale.register-index');
Route::post('/sales-register-action', [SaleController::class, 'register_action'])->name('sale.register-action');

// Ruta para generar orden de compra y sus detalles
Route::get('/purchase-generate-index', [PurchaseController::class, 'generate_index'])->name('purchase.generate-index');
Route::post('/purchase-generate-action', [PurchaseController::class, 'generate_action'])->name('purchase.generate-action');
Route::get('/purchase-filter-supplier-async', [App\Http\Controllers\PurchaseController::class, 'filter_supplier_async'])->name('purchase.filter-supplier-async');
Route::get('/purchase-filter-code-async', [App\Http\Controllers\PurchaseController::class, 'filter_code_async'])->name('purchase.filter-code-async');


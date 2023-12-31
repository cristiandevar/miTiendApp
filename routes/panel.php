<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDetailController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;

// Rutas para redirigir al login o al panel segun corresponda
Route::get('/', [HomeController::class, 'index'])->name('panel');
Route::get('/home', [HomeController::class, 'index']);


Route::group(['middleware' => ['can:func_admin']], function () {
    // Rutas para el CRUD de productos
    Route::resource('/products', ProductController::class)->names('product');
    Route::get('/product/show/edit/{id}',
        function($id){
            $controller = new ProductController();
            return $controller->show_edit(Product::where('id',$id)->first());
        }
    )->name('product.show-edit');
    Route::put('/product/show/edit/comfirm/{id}',
        function(Request $request, $id){
            $controller = new ProductController();
            return $controller->update_show($request, Product::where('id',$id)->first());
        }
    )->name('product.show-update');
    
    // Rutas para el CRUD de categorias
    Route::resource('/categories', CategoryController::class)->names('category');
    Route::get('/category/show/edit/{id}',
        function($id){
            $controller = new CategoryController();
            return $controller->show_edit(Category::where('id',$id)->first());
        }
    )->name('category.show-edit');
    Route::put('/category/show/edit/comfirm/{id}',
        function(Request $request, $id){
            $controller = new CategoryController();
            return $controller->update_show($request, Category::where('id',$id)->first());
        }
    )->name('category.show-update');

    // Rutas para el CRUD de proveedores
    Route::resource('/suppliers', SupplierController::class)->names('supplier');
    Route::get('/supplier/show/edit/{id}',
    function($id){
        $controller = new SupplierController();
        return $controller->show_edit(Supplier::where('id',$id)->first());
    }
    )->name('supplier.show-edit');
    Route::put('/supplier/show/edit/comfirm/{id}',
        function(Request $request, $id){
            $controller = new SupplierController();
            return $controller->update_show($request, Supplier::where('id',$id)->first());
        }
    )->name('supplier.show-update');

    // Rutas para el CRUD de empleados
    Route::resource('/employees', EmployeeController::class)->names('employee');

    // Rutas para CRUD detalles de compras
    Route::resource('/purchasesdetails', PurchaseDetailController::class)->names('purchasedetail');

    // Rutas para el CRUD de usuarios
    Route::resource('/users', UserController::class)->names('user');
    Route::get('/user/show/edit/{id}',
    function($id){
        $controller = new UserController();
        return $controller->show_edit(User::where('id',$id)->first());
    }
    )->name('user.show-edit');
    Route::put('/user/show/edit/comfirm/{id}',
        function(Request $request, $id){
            $controller = new UserController();
            return $controller->update_show($request, User::where('id',$id)->first());
        }
    )->name('user.show-update');
});

Route::group(['middleware' => ['can:func_boss']], function () {
    //Ruta para graficos y datos
    Route::get('/get-data',[HomeController::class, 'get_data'])->name('get-data');
    Route::get('/get-data-purch-sale',[HomeController::class, 'get_data_purch_sale'])->name('get-data-purch_sale');
    Route::get('/get-data-in-out',[HomeController::class, 'get_data_in_out'])->name('get-data-in_out');
    
    
    
    
    
    
    
    // Rutas para CRUD ventas
    Route::resource('/sales', SaleController::class)->names('sale');
    Route::get('/sale/show/edit/{id}',
        function($id){
            $controller = new SaleController();
            return $controller->show_edit(Sale::where('id',$id)->first());
        }
    )->name('sale.show-edit');
    Route::put('/sale/show/edit/comfirm/{id}',
        function(Request $request, $id){
            $controller = new SaleController();
            return $controller->update_show($request, Sale::where('id',$id)->first());
        }
    )->name('sale.show-update');
    
    Route::get('/sale/invoice',
        function(Request $request){
            $controller = new SaleController();
            return $controller->export_file_sale(Sale::where('id',$request->sale_id)->first(), 'pdf');
        }
    )->name('sale.export-file');
    

    // Rutas para CRUD compras
    Route::resource('/purchases', PurchaseController::class)->names('purchase');
    Route::get('/purchase/edit/show/{id}',
        function($id){
            $controller = new PurchaseController();
            return $controller->show_edit(Purchase::where('id',$id)->first());
        }
    )->name('purchase.show-edit');
    
    Route::put('/purchase/show/edit/comfirm/{id}',
        function(Request $request, $id){
            $controller = new PurchaseController();
            return $controller->update_show($request, Purchase::where('id',$id)->first());
        }
    )->name('purchase.show-update');
    
    Route::get('/purchase/voucher',
        function(Request $request){
            $controller = new PurchaseController();
            return $controller->export_file_purchase(Purchase::where('id',$request->purchase_id)->first(), 'pdf');
        }
    )->name('purchase.export-file');

    Route::get('/purchase/many_vouchers',
        function(Request $request){
            $purchases = [];

            foreach($request->all() as $input){
                $purchases[] = Purchase::where('id',$input)->first();
            }
            $controller = new PurchaseController();
            return $controller->export_file_many_purchase($purchases, 'pdf');
        }
    )->name('purchase.export-many-file');

    // Rutas para actualizar precio
    Route::get('/products-filter-price-update', [App\Http\Controllers\ProductController::class, 'update_price'])->name('product.update-price');
    Route::post('/products-filter-price-update-async', [App\Http\Controllers\ProductController::class, 'update_price_async'])->name('product.update-price-async');
    
    // Ruta para registrar venta y sus detalles
    Route::get('/sales-register-index', [SaleController::class, 'register_index'])->name('sale.register-index');
    Route::post('/sales-register-action', [SaleController::class, 'register_action'])->name('sale.register-action');

    // Ruta para generar orden de compra y sus detalles
    Route::get('/purchase-generate-index', [PurchaseController::class, 'generate_index'])->name('purchase.generate-index');
    Route::post('/purchase-generate-action', [PurchaseController::class, 'generate_action'])->name('purchase.generate-action');
    Route::get('/purchase-filter-supplier-async', [App\Http\Controllers\PurchaseController::class, 'filter_supplier_async'])->name('purchase.filter-supplier-async');
    Route::get('/purchase-filter-code-async', [App\Http\Controllers\PurchaseController::class, 'filter_code_async'])->name('purchase.filter-code-async');
    Route::get('/purchase-filter-async-products', [App\Http\Controllers\PurchaseController::class, 'filter_async_products'])->name('purchase.filter-async');

    // Rutas para registrar compras
    Route::get('/purchase-register-index', [PurchaseController::class, 'register_index'])->name('purchase.register-index');
    Route::post('/purchase-register-action', [PurchaseController::class, 'register_action'])->name('purchase.register-action');
    Route::get('/purchase-filter-async-purchases-register', [App\Http\Controllers\PurchaseController::class, 'filter_async_purchases_register'])->name('purchase.filter-async-purchases-register');
    Route::get('/purchase-filter-async', [App\Http\Controllers\PurchaseController::class, 'filter_async_id'])->name('purchase.filter-async-purchase');

    // Ruta para cancelar orden de compra
    Route::post('/purchase-cancel-action', [PurchaseController::class, 'cancel_action'])->name('purchase.cancel-action');
    
    // Ruta para actualizar orden de compra
    Route::post('/purchase-update-action', [PurchaseController::class, 'update_action'])->name('purchase.update-action');
    

});

Route::group(['middleware' => ['can:func_seller']], function () {
    // Ruta para filtro de productos
    Route::get('/products-filter', [App\Http\Controllers\ProductController::class, 'filter'])->name('product.filter');
    Route::get('/products-filter-price', [App\Http\Controllers\ProductController::class, 'filter_price'])->name('product.filter-price');
    Route::get('/products-filter-async', [App\Http\Controllers\ProductController::class, 'filter_async'])->name('product.filter-async');
    Route::get('/products-query-price', [App\Http\Controllers\ProductController::class, 'query_price'])->name('product.query-price');
    Route::get('/products-query-price-async', [App\Http\Controllers\ProductController::class, 'query_price_async'])->name('product.query-price-async');

    // Ruta para exportar archivos
    Route::get('/products-export-file', [App\Http\Controllers\ProductController::class, 'export_file'])->name('products.export-file'); 
});


// Route::get('/test',[App\Http\Controllers\ProductController::class, 'prueba'])->name('products.export-file'); 

// Route::get('/test',
//         function(){
//             $controller = new PurchaseController();
//             return $controller->test_pdf();
//         }
//     )->name('purchase.test-pdf');
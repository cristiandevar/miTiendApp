<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        // Retornamos una vista y enviamos la variable 'products'
        $categories = Category::where('active',1)->get();
        $suppliers = Supplier::where('active',1)->get();
        return view('panel.products.crud.index', compact('products', 'categories', 'suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un producto nuevo para cargarle datos
        $product = new Product();

        // Recuperamos todas las categorias de la BD
        $categories = Category::where('active', 1)->get(); // Recordar importar el modelo Categoria!!
        
        $suppliers = Supplier::where('active', 1)->get(); // Recordar importar el modelo Categoria!!
        // Retornamos la vista de creacion de productos, enviamos el producto y las categorias
        
        return view('panel.products.crud.create', compact('product', 'categories','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'price' => 'required|max: 99999999',
            'stock' => 'required|max: 9999',
            'category_id' => 'required',
            'supplier_id' => 'required',
        ]);

        $product = new Product();

        if ($request->description) {
            $product->description = $request->get('description');
        }
        if ($request->hasFile('image')) {
            // Subida de imagen al servidor (public > storage)
            $image_url = $request->file('image')->store('public/product');
            $product->image = asset(str_replace('public', 'storage', $image_url));
        }

        if ($request->get('active')) {
            $product->active = 1;
        }
        else {
            $product->active = 0;
        }
        if ($request->minstock) {
            $product->minstock = $request->get('minstock');
        }
        
        $product->name = $request->get('name');
        $product->code = $request->get('code');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');
        $product->category_id = $request->get('category_id');
        $product->supplier_id = $request->get('supplier_id');

        // Almacena la info del producto en la BD
        $product->save();

        return redirect()
            ->route('product.index')
            ->with('alert', 'Producto "' . $product->name . '" agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('panel.products.crud.show', compact('product'));
    }

    public function show_edit(Product $product)
    {
        $categories = Category::where('active', 1)->get();
        $suppliers = Supplier::where('active', 1)->get();
        $back = true;
        return view('panel.products.crud.edit', compact('product', 'categories', 'suppliers', 'back'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', 1)->get();
        $suppliers = Supplier::where('active', 1)->get(); 
        
        return view('panel.products.crud.edit', compact('product', 'categories', 'suppliers'));
    
    }

    public function update_show(Request $request, Product $product){
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'price' => 'required|max: 99999999',
            'stock' => 'required|max: 9999',
            'category_id' => 'required',
            'supplier_id' => 'required',
        ]);

        $product->name = $request->get('name');
        $product->code = $request->get('code');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');
        $product->category_id = $request->get('category_id');
        $product->supplier_id = $request->get('supplier_id');
        
        if ($request->get('active')) {
            $product->active = 1;
        }
        else {
            $product->active = 0;
        }
        if ($request->get('description')) {
            $product->description = $request->get('description');
        }
        if ($request->minstock) {
            $product->minstock = $request->get('minstock');
        }
        if ($request->hasFile('image')) {
        // Subida de la imagen nueva al servidor
            $this->deleteImage($product->image);
            $image_url = $request->file('image')->store('public/product');
            $product->image = asset(str_replace('public', 'storage', $image_url));
        }
        
        
        // Actualiza la info del producto en la BD
        $product->update();

        return redirect()
            ->route('product.show', compact('product'))
            ->with('alert', 'Producto "' .$product->name. '" actualizado exitosamente.');
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'price' => 'required|max: 99999999',
            'stock' => 'required|max: 9999',
            'category_id' => 'required',
            'supplier_id' => 'required',
        ]);

        $product->name = $request->get('name');
        $product->code = $request->get('code');
        $product->price = $request->get('price');
        $product->stock = $request->get('stock');
        $product->category_id = $request->get('category_id');
        $product->supplier_id = $request->get('supplier_id');
        
        if ($request->get('active')) {
            $product->active = 1;
        }
        else {
            $product->active = 0;
        }
        if ($request->get('description')) {
            $product->description = $request->get('description');
        }
        if ($request->minstock) {
            $product->minstock = $request->get('minstock');
        }
        if ($request->hasFile('image')) {
        // Subida de la imagen nueva al servidor
            $this->deleteImage($product->image);
            $image_url = $request->file('image')->store('public/product');
            $product->image = asset(str_replace('public', 'storage', $image_url));
        }
        
        
        // Actualiza la info del producto en la BD
        $product->update();

        return redirect()
            ->route('product.index')
            ->with('alert', 'Producto "' .$product->name. '" actualizado exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // $product->delete();
        $product->active = 0;
        
        $product->update();

        return redirect()
            ->route('product.index')
            ->with('alert', 'Producto "'.$product->name.'" eliminado exitosamente.');
    }

    public function deleteImage(string $path)
    {
        $image_url = str_replace(asset(''), public_path().'/',$path);
        $image_url = str_replace('\\', '/', $image_url);
        unlink($image_url);
    }

    public function filter(Request $request) {

        $products = $this->filter_gral($request)
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();

        return view('panel.products.filters.filter',compact('products','suppliers', 'categories'));

    }

    public function filter_price(Request $request) {

        $products = $this->filter_gral($request)
            ->latest()
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();

        return view('panel.products.filters.filter-price',compact('products','suppliers', 'categories'));

    }

    public function filter_async(Request $request) {

        $products = $this->filter_gral($request)
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();

        return response()->json(
            [
                // 'inputs' => $inputs,
                'products' => $products,
                'categories' => $categories,
                'suppliers' => $suppliers
            ]
        );
    }

    public function update_price_async(Request $request) {
        $request->validate([
            'percentage' => 'numeric|max:100|min:-100',
        ]);
        
        $products = $this->filter_gral($request)->latest()->get();

        if ($request->has('percentage') && $request->percentage !== '' && count($products) > 0) {
            $products_update = collect();
            foreach ($products as $product) {
                $price = $product->price;
                $percentage = $request->percentage;

                $price = $price * (1 + $percentage/100);

                $product_update = Product::find($product->id);
                $product_update->price = $price;
                $product_update->update();

                $products_update->push(Product::find($product->id));
                
            }
            $products = $products_update;
        }

        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();
        
        return response()->json(
            [
                'products' => $products,
                'categories' => $categories,
                'suppliers' => $suppliers,
            ]
        );

    }

    public function query_price(Request $request){

        $products = $this->filter_gral($request)
            ->latest()
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();
            
        if (count($request->all())) {

            return response()->json(
                [
                    'products' => $products,
                    'categories' => $categories,
                    'suppliers' => $suppliers
                ]
            );
        }
        else {
            return view('panel.products.filters.query-price', compact('products', 'categories', 'suppliers'));
        }

    }    

    public function export_file(Request $request) {
        $columns = ['id','name','stock','price','category_id','supplier_id'];
        $headings = ['ORDEN','NOMBRE','STOCK','PRECIO','CATEGORIA','PROVEEDOR'];
        $names = [
            'created_at' => 'Fecha de Creación',
            'stock' => 'Stock',
            'code' => 'Código',
            'name' => 'Nombre',
            'price' => 'Precio',
            'category' => 'Categoria',
            'supplier' => 'Proveedor',
        ];
        if ($request->action == 'excel') {
            $headings = ['ORDEN','NOMBRE','STOCK','PRECIO','CATEGORIA','PROVEEDOR'];
            $content = $this->filter_gral($request);
            if(count($content) > 0){
                return Excel::download(new ProductsExport($content,$columns, $headings),'productos.xlsx');
            }
            else return $this->filter(new Request());
        }
        else if ($request->action == 'pdf') {
            $content = $this->filter_gral($request)->latest()->get();
            $order = [
                'order_by' => $names[$request->order_by_1],
                'order_type' => $request->order_by_2,
            ];
            if(count($content) > 0){
                return $this->export_pdf($content, $order, 'Productos', 'Listado filtrado', 'Listado filtrado de productos', $columns, $headings);
            }
            else return $this->filter(new Request());
        }
    }

    public function filter_gral (Request $request) {
        $query = Product::query();
        if ($request->has('id') && Str::length((trim($request->id)))>0) {
            $query->where('id', $request->id);
        }

        if ($request->has('name') && Str::length((trim($request->name)))>0) {
            $query->where('name','like', '%'.$request->name.'%');
        }
        if ($request->has('code') && Str::length((trim($request->code)))>0) {
            $query->where('code','like', '%'.$request->code.'%');
            // dd('entro');
        }
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('price_since') && $request->price_since) {
            $query->where('price','>=', $request->price_since);
        }
        if ($request->has('price_to') && $request->price_to) {
            $query->where('price','<=', $request->price_to);
        }
        if ($request->has('stock_since') && $request->stock_since) {
            $query->where('stock','>=', $request->stock_since);
        }
        if ($request->has('stock_to') && $request->stock_to) {
            $query->where('stock','<=', $request->stock_to);
        }
        if ($request->has('date_since') && $request->date_since) {
            $query->where('created_at','>=', $request->date_since);
        }
        if ($request->has('date_to') && $request->date_to) {
            $date_to = Carbon::createFromFormat('Y-m-d',$request->date_to )->startOfDay()->addDay()->toDateTimeString();
            $query->where('created_at','<', $date_to);
        }

        $order_by = [];

        if ($request->has('order_by_1') && Str::length((trim($request->order_by_1)))>0) {
            $order_by['column'] = $request->order_by_1;
        }
        if ($request->has('order_by_2') && Str::length((trim($request->order_by_2)))>0) {
            $order_by['mode'] = $request->order_by_2;
        }

        if(count($order_by)>0){
            $query = $this->order_gral($query, $order_by);
            return $query->where('products.active', 1);
        }
        else {
            return $query->where('active', 1);

        }
        
    }

    public function order_gral($query, $order_by){
        

        if(count($order_by) > 0){
            if($order_by['column'] && ($order_by['column']=='category' || $order_by['column'] == 'supplier')){
                if($order_by['column']=='category'){
                    $query->join('categories', 'products.category_id', '=', 'categories.id')
                        ->select('products.*', 'categories.name AS category_name');
                    if($order_by['mode'] == 'desc'){
                        $query->orderBy('category_name','DESC');
                    }
                    else {
                        $query->orderBy('category_name');
                    }
                }
                else {
                    $query->join('suppliers', 'products.supplier_id', '=', 'suppliers.id')
                        ->select('products.*', 'suppliers.companyname AS supplier_name');
                    if($order_by['mode'] == 'desc'){
                        $query->orderBy('supplier_name','DESC');
                    }
                    else {
                        $query->orderBy('supplier_name');
                    }
                }
                
            }
            else if($order_by['column']){
                if($order_by['mode'] == 'desc'){
                    $query->orderBy($order_by['column'],'DESC');
                }
                else {
                    $query->orderBy($order_by['column']);
                }
            }
            else {
                if($order_by['mode'] == 'desc'){
                    $query->oldest();
                }
                else{
                    $query->latest();
                }
            }
        }
        else{
            $query->latest();
        }

        return $query;
    }

    public function export_pdf(Collection $content, $order, string $title, string $subtitle, string $file_title, $columns, $headings){
        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'products' => $content,
            'columns' => $columns,
            'headings' => $headings,
            'order_by' => $order['order_by'],
            'order_type' => $order['order_type'],
        ];
        
        $pdf = PDF::loadView('pdf.product_list', $data);
        
        return $pdf->download($file_title.'.pdf');
    }

    public function get_product(Request $request){
        $product = Product::where('id', $request->id);

        return response()->json(
            [
                'product'=>$product
            ]
        );
    }
}

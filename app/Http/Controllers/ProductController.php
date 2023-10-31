<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->category_id = $request->get('category_id');
        $product->supplier_id = auth()->user()->id;

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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', 1)->get();
        $suppliers = Supplier::where('active', 1)->get(); 
        
        return view('panel.products.crud.edit', compact('product', 'categories', 'suppliers'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($request->hasFile('image')) {
        // Subida de la imagen nueva al servidor
            $this->deleteImage($product->image);
            $image_url = $request->file('image')->store('public/product');
            $product->image = asset(str_replace('public', 'storage', $image_url));
        }

        if ($request->get('active')) {
            $product->active = 1;
        }
        else {
            $product->active = 0;
        }
        if ($request->get('description')) {
            $product->description = $request->get('description');
        }
        
        $product->name = $request->get('name');
        $product->price = $request->get('price');
        $product->category_id = $request->get('category_id');
        $product->supplier_id = $request->get('supplier_id');
        
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

    public function deleteImage(string $path) {
        $image_url = str_replace(asset(''), public_path().'/',$path);
        $image_url = str_replace('\\', '/', $image_url);
        unlink($image_url);
    }

    public function filter(Request $request) {
        $query = Product::query();
        if ($request->has('name') && Str::length((trim($request->name)))>0) {
            $query->where('name','like', '%'.$request->name.'%');
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
        if ($request->has('date_since') && $request->date_since) {
            $query->where('created_at','>=', $request->date_since);
        }
        if ($request->has('date_to') && $request->date_to) {
            $date_to = Carbon::createFromFormat('Y-m-d',$request->date_to )->startOfDay()->addDay()->toDateTimeString();
            $query->where('created_at','<', $date_to);
        }

        $inputs = $request->all();

        $products = $query->where('active', 1)
            ->latest()
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();

        return view('panel.products.filters.filter',compact('products','suppliers', 'categories', 'inputs'));

    }

    public function filter_price(Request $request) {

        $query = Product::query();

        if ($request->has('name') && Str::length((trim($request->name)))>0) {
            $query->where('name','like', '%'.$request->name.'%');
        }
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('date_since') && $request->date_since) {
            $query->where('created_at','>=', $request->date_since);
        }
        if ($request->has('date_to') && $request->date_to) {
            $date_to = Carbon::createFromFormat('Y-m-d',$request->date_to )->startOfDay()->addDay()->toDateTimeString();
            $query->where('created_at','<', $date_to);
        }
        $inputs = $request->all();

        $products = $query->where('active', 1)
            ->latest()
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();

        return view('panel.products.filters.filter-price',compact('products','suppliers', 'categories', 'inputs'));

    }

    public function update_price(Request $request) {
        // $products =json_decode($request->get('products'), true);
        $inputs = json_decode($request->get('inputs'), true);

        $query = Product::query();

        if (isset($inputs['name']) && $inputs['name'] && Str::length((trim($inputs['name'])))>0) {
            $query->where('name','like', '%'.$inputs['name'].'%');
        }
        if (isset($inputs['supplier_id']) && $inputs['supplier_id']) {
            $query->where('supplier_id', $inputs['supplier_id']);
        }
        if (isset($inputs['category_id']) && $inputs['category_id']) {
            $query->where('category_id', $inputs['category_id']);
        }
        if (isset($inputs['date_since']) && $inputs['date_since']) {
            $query->where('created_at','>=', $inputs['date_since']);
        }
        if (isset($inputs['date_to']) && $inputs['date_to']) {
            $date_to = Carbon::createFromFormat('Y-m-d',$inputs['date_to'] )->startOfDay()->addDay()->toDateTimeString();
            $query->where('created_at','<', $date_to);
        }

        $products = $query->where('active', 1)->get();
        
        if ($request->percentage && $request->percentage !== '') {
            dd($products);
            $products_update = [];
            foreach ($products as $product) {
                $price = $product->price;
                $percentage = $request->percentage;

                $price = $price * (1 + $percentage/100);

                $product_update = Product::find($product->id);
                $product_update->price = $price;
                $product_update->update();

                $products_update[] = Product::find($product->id);
                
            }
        }
        else {
            $products_update = $products;
        }

        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();
        $products = $products_update;

        return view('panel.products.filters.filter-price',compact('products','suppliers', 'categories', 'inputs'));

    }

    public function filter_price_async(Request $request) {

        $query = Product::query();

        if ($request->has('name') && Str::length((trim($request->name)))>0) {
            $query->where('name','like', '%'.$request->name.'%');
        }
        if ($request->has('supplier_id') && $request->supplier_id) {
            $query->where('supplier_id', $request->supplier_id);
        }
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('date_since') && $request->date_since) {
            $query->where('created_at','>=', $request->date_since);
        }
        if ($request->has('date_to') && $request->date_to) {
            $date_to = Carbon::createFromFormat('Y-m-d',$request->date_to )->startOfDay()->addDay()->toDateTimeString();
            $query->where('created_at','<', $date_to);
        }
        $inputs = $request->all();

        $products = $query->where('active', 1)
            ->latest()
            ->get(); 
        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();

        return response()->json(
            [
                'inputs' => $inputs,
                'products' => $products,
                'categories' => $categories,
                'suppliers' => $suppliers
            ]
        );
        // return view('panel.products.filters.filter-price',compact('products','suppliers', 'categories', 'inputs'));

    }

    public function update_price_async(Request $request) {
        // $products =json_decode($request->get('products'), true);
        $inputs = json_decode($request->get('inputs'), true);

        // $query = Product::query();

        // if (isset($inputs['name']) && $inputs['name'] && Str::length((trim($inputs['name'])))>0) {
        //     $query->where('name','like', '%'.$inputs['name'].'%');
        // }
        // if (isset($inputs['supplier_id']) && $inputs['supplier_id']) {
        //     $query->where('supplier_id', $inputs['supplier_id']);
        // }
        // if (isset($inputs['category_id']) && $inputs['category_id']) {
        //     $query->where('category_id', $inputs['category_id']);
        // }
        // if (isset($inputs['date_since']) && $inputs['date_since']) {
        //     $query->where('created_at','>=', $inputs['date_since']);
        // }
        // if (isset($inputs['date_to']) && $inputs['date_to']) {
        //     $date_to = Carbon::createFromFormat('Y-m-d',$inputs['date_to'] )->startOfDay()->addDay()->toDateTimeString();
        //     $query->where('created_at','<', $date_to);
        // }

        // $products = $query->where('active', 1)->get();
        
        $products_update = collect();
        if ($request->percentage && $request->percentage !== '') {
            foreach ($request->products as $product) {
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
        else {
            $products = $request->get('products');
        }

        $categories = Category::where('active',1)
            ->latest()
            ->get();
        $suppliers = Supplier::where('active',1)
            ->latest()
            ->get();
        
        $percentage = $request->percentage;
        return response()->json(
            [
                'products' => $products,
                'inputs' => $inputs,
                'products' => $products,
                'categories' => $categories,
                'suppliers' => $suppliers,
                'percentage' => $percentage
            ]
        );
        // return view('panel.products.filters.filter-price',compact('products','suppliers', 'categories', 'inputs'));

    }
}

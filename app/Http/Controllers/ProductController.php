<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

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
        return view('panel.seller.products_list.index', compact('products', 'categories', 'suppliers'));
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
        return view('panel.seller.products_list.create', compact('product', 'categories','suppliers'));
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
        return view('panel.seller.products_list.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', 1)->get();
        $suppliers = Supplier::where('active', 1)->get(); 
        
        return view('panel.seller.products_list.edit', compact('product', 'categories', 'suppliers'));
    
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

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->has('supplier')) {
            $query->where('supplier_id', $request->supplier);
        }
        if ($request->has('price_since')) {
            $query->where('price','>=', $request->price_since);
        }
        if ($request->has('price_to')) {
            $query->where('price','<=', $request->price_to);
        }
        if ($request->has('name')) {
            $query->where('name','like', '%'.$request->name.'%');
        }

        $inputs = $request->all();

        $products = Product::where('active', 1)
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
}

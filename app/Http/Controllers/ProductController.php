<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('seller_id', auth()->user()->id)
            ->where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        $categories = Category::get()->where('active', 1);
        // Retornamos una vista y enviamos la variable 'products'
        return view('panel.seller.products_list.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un producto nuevo para cargarle datos
        $product = new Product();
        // Recuperamos todas las categorias de la BD
        $categories = Category::get()->where('active', 1); // Recordar importar el modelo Categoria!!
        // Retornamos la vista de creacion de productos, enviamos el producto y las categorias
        return view('panel.seller.products_list.create', compact('product', 'categories'));
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
        else {
            $product->description = '';
        }
        
        
        $product->name = $request->get('name');

        $product->price = $request->get('price');
        $product->category_id = $request->get('category_id');
        $product->seller_id = auth()->user()->id;
        if ($request->hasFile('image')) {
        // Subida de imagen al servidor (public > storage)
        $image_url = $request->file('image')->store('public/product');
        $product->image = asset(str_replace('public', 'storage', $image_url));
        } else {
        $product->image = '';
        }

        if ($request->get('active')) {
            $product->active = 1;
        }
        else {
            $product->active = 0;
        }
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
        $categories = Category::get()->where('active', 1);
        return view('panel.seller.products_list.edit', compact('product', 'categories'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->category_id = $request->get('category_id');
        if ($request->hasFile('image')) {
        // Subida de la imagen nueva al servidor
        $image_url = $request->file('image')->store('public/product');
        $product->image = asset(str_replace('public', 'storage', $image_url));
        }

        if ($request->get('active')) {
            $product->active = 1;
        }
        else {
            $product->active = 0;
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
}

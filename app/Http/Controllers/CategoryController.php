<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('seller_id', auth()->user()->id)
        ->where('active', 1)    
        ->latest()
            ->get();

        return view('panel.seller.categories_list.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos una nueva categoria
        $category = new Category();

        // Retornamos la vista de creacion de categorias
        return view('panel.seller.categories_list.create', compact('category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->get('name');
        $category->active = $request->get('active');
        $category->seller_id = auth()->user()->id;

        $category->save();

        return redirect()
        ->route('category.index')
        ->with('alert','Categoria "'.$category->name.'"agregada exitosamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('panel.seller.categories_list.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('panel.seller.categories_list.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->get('name');
        $category->active = $request->get('active');

        $category->update();

        return redirect()
        ->route('category.index')
        ->with('alert', 'Categoria "'.$category->name.'" actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // $category->delete();
        $category->active = 0;
        
        return redirect()
        ->route('category.index')
        ->with('alert','Categoria "'.$category->name.'" eliminada exitosamente');
    }
}

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
        $categories = Category::where('active', 1)    
            ->latest()
            ->get();

        return view('panel.categories.crud.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos una nueva categoria
        $category = new Category();

        // Retornamos la vista de creacion de categorias
        return view('panel.categories.crud.create', compact('category'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->get('name');

        // dd($request->get('active'));
        if ($request->get('active')) {
            $category->active = 1;
        }
        else {
            $category->active = 0;
        }

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
        return view('panel.categories.crud.show', compact('category'));
    }

    public function show_edit(Category $category)
    {
        $back = true;
        return view('panel.categories.crud.edit', compact('category', 'back'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('panel.categories.crud.edit', compact('category'));
    }

    public function update_show(Request $request, Category $category)
    {
        $msg = 'Categoria "'.$category->name.'" actualizada exitosamente';
        $category->name = $request->get('name');
        if ($request->get('active')) {
            $category->active = 1;
        }
        else {
            if (!$category->products()->first()) {
                $category->active = 0;
            }
            else {
                $msg = 'No se pudo eliminar, porque tiene productos asociados';
            }
        }
        
        $category->update();

        return redirect()
            ->route('category.show', compact('category'))
            ->with('alert', $msg);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $msg = 'Categoria "'.$category->name.'" actualizada exitosamente';
        $category->name = $request->get('name');
        if ($request->get('active')) {
            $category->active = 1;
        }
        else {
            if (!$category->products()->first()) {
                $category->active = 0;
            }
            else {
                $msg = 'No se pudo eliminar, porque tiene productos asociados';
            }
        }
        
        $category->update();

        return redirect()
            ->route('category.index')
            ->with('alert', $msg);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $products = $category->products()->where('active',1)->get(); 
        
        if (count($products) > 0) {
            return redirect()
                ->route('category.index')
                ->with('error','No se pudo eliminar "'.$category->name.'" dado que posee productos asociados');

        }
        else{
            $category->active = 0;
            $category->update();
            
            return redirect()
            ->route('category.index')
            ->with('alert','Categoria "'.$category->name.'" eliminada exitosamente');
        }

        // $msg = 'Categoria "'.$category->name.'" eliminada exitosamente';
        // if (!$category->products()->first()) {
        //     $category->active = 0;
        //     $category->update();
        // }
        // else {
        //     $msg = 'No se pudo eliminar "'.$category->name.'" dado que posee elementos asociados';
        // }
        // return redirect()
        //     ->route('category.index')
        //     ->with('alert',$msg);
    }
}

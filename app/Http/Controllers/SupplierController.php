<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::where('active', 1)
            ->get();

        return view('panel.admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un empleado nuevo para cargarle datos
        $supplier = new Supplier();
        
        // Retornamos la vista de creacion de suppliersos, enviamos el supplierso y las categorias
        return view('panel.admin.suppliers.create', compact('supplier'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supplier = new Supplier();

        if ($request->has('email')) {
            $supplier->email = $request->get('email');
        }

        if ($request->has('phone')) {
            $supplier->phone = $request->get('phone');
        }
               
        if ($request->has('address')) {
            $supplier->address = $request->get('address');
        }

        $supplier->companyname = $request->get('companyname');

        // Almacena la info del Proveedor en la BD
        $supplier->save();

        return redirect()
            ->route('supplier.index')
            ->with('alert', 'Empleado "' . $supplier->companyname . '" agregado exitosamente.');
    
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return view('panel.admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('panel.admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        if ($request->has('email')) {
            $supplier->email = $request->get('email');
        }

        if ($request->has('phone')) {
            $supplier->phone = $request->get('phone');
        }

        if ($request->has('address')) {
            $supplier->address = $request->get('address');
        }

        $supplier->companyname = $request->get('companyname');

        // Actualiza la info del suppliero en la BD
        $supplier->update();

        return redirect()
            ->route('supplier.index')
            ->with('alert', 'Proveedor "' .$supplier->companyname. '" actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $products = Product::where('supplier_id', $supplier->id);
        if ($products->first()) {
            return redirect()
                ->route('supplier.index')
                ->with('error', 'No se pudo eliminar "'.$supplier->companyname.'" dado que tiene productos asociados');
        }
        else {
            $supplier->active = 0;
            $supplier->update();
    
            return redirect()
                ->route('supplier.index')
                ->with('alert', 'Proveedor "'.$supplier->companyname.'" eliminado exitosamente');
        }
    }
}

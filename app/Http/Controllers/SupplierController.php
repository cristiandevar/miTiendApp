<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
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

        return view('panel.suppliers.crud.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un empleado nuevo para cargarle datos
        $supplier = new Supplier();
        
        // Retornamos la vista de creacion de suppliersos, enviamos el supplierso y las categorias
        return view('panel.suppliers.crud.create', compact('supplier'));
    
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
        return view('panel.suppliers.crud.show', compact('supplier'));
    }

    public function show_edit(Supplier $supplier)
    {
        $back = true;
        return view('panel.suppliers.crud.edit', compact('supplier','back'));
    }    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('panel.suppliers.crud.edit', compact('supplier'));
    }

    public function update_show(Request $request, Supplier $supplier)
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
            ->route('supplier.show', compact('supplier'))
            ->with('alert', 'Proveedor "' .$supplier->companyname. '" actualizado exitosamente.');
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
        $products = Product::where('supplier_id', $supplier->id)->where('active', 1)->get();
        $purchases = Purchase::where('supplier_id',$supplier->id)->where('received_date','=',null)->get();
        if (count($products) > 0 && count($purchases) > 0) {
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

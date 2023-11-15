<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); 
            // Retornamos una vista y enviamos la variable 'sales'
        return view('panel.purchases.crud.index', compact('purchases', 'suppliers'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un producto nuevo para cargarle datos
        $purchase = new Purchase();

        $date = date("d-m-Y");

        // Recuperamos todas las categorias de la BD
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get();

        return view('panel.purchases.crud.create', compact('purchase', 'suppliers', 'date'));
    
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'date' => 'required',
            'supplier_id' => 'required'
        ]);

        $purchase = new Purchase();

        if ($request->get('active')) {
            $purchase->active = 1;
        }
        else {
            $purchase->active = 0;
        }
        $purchase->supplier_id = $request->get('supplier_id');

        // Almacena la info del saleo en la BD
        $purchase->save();

        return redirect()
            ->route('purchase.index')
            ->with('alert', 'Compra nro:"' . $purchase->id . '" agregada exitosamente.');
    
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        return view('panel.purchases.crud.show', compact('purchase'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {

        $date = $purchase->created_at;

        // Recuperamos todas las categorias de la BD
        $suppliers = Supplier::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get();

        return view('panel.purchases.crud.edit', compact('purchase', 'suppliers', 'date'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            // 'date' => 'required',
            'supplier_id' => 'required'
        ]);

        if ($request->get('active')) {
            $purchase->active = 1;
        }
        else {
            $purchase->active = 0;
        }
        $purchase->supplier_id = $request->get('supplier_id');

        // Almacena la info de la venta en la BD
        $purchase->update();

        return redirect()
            ->route('purchase.index')
            ->with('alert', 'Compra nro:"' . $purchase->id . '" modificada exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->active = 0;
        
        $purchase->update();

        return redirect()
            ->route('purchase.index')
            ->with('alert', 'Compra nro: "'.$purchase->id.'" eliminada exitosamente.');
    
    
    }

    public function generate_index(){
        $products = Product::where('active', 1)->latest()->get();
        $categories = Category::where('active', 1)->latest()->get();
        $suppliers = Supplier::where('active', 1)->latest()->get();
        
        return view('panel.purchases.generate.index', compact('products', 'categories', 'suppliers'));
    
    }

    public function filter_supplier_async(Request $request){
        
        $query = Product::query();

        if ($request->has('supplier_id') && Str::length((trim($request->supplier_id)))>0) {
            $query->where('supplier_id', $request->supplier_id);
        }

        $query = $query->whereRaw('stock <= minstock');
    
        $products = $query
        ->where('active',1)
        ->latest()
        ->get();
        
        // dd($products);
        return response()->json(
            [
                'products' => $products,
            ]
        );
        
    }
}

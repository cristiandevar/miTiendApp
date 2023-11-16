<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
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
        
        $query = Product::query();

        $query->whereRaw('stock <= minstock');
        
        
        $products = $query->where('active', 1)
            ->latest()
            ->get();
        $categories = Category::where('active', 1)->latest()->get();
        $suppliers = Supplier::where('active', 1)->latest()->get();
        
        return view('panel.purchases.generate.index', compact('products', 'categories', 'suppliers'));
    
    }

    public function generate_action(Request $request){
        
        $query = Supplier::query();

        if ( $request->has('supplier_id') ) {
            $query -> where('id',$request->supplier_id );
        }

        $suppliers = $query->where('active',1)->get();
        
        $b = 0;
        $purchase = new Purchase();
        
        foreach ( $suppliers as $supplier ) {
            if ( $b==1 ) {
                $purchase = new Purchase();
                $b=0;
            }
            $purchase->supplier_id = $supplier->id;
            for ($i = 0; $i<$request->qty;$i++){
                $product = Product::where('id',$request->$i['product_id'])->first();
                if ($product->supplier_id == $supplier->id){
                    $detail = new PurchaseDetail();
                    $detail->product_id = $product->id;
                    $detail->quantity = $request->$i['quantity'];
                    if($b==0){
                        $purchase->save();
                        $b=1;
                    }
                    $detail->purchase_id = $purchase->id;
                    $detail->save();
                }
            }
        }

        return response()->json([
            'msj'=> 'Respuesta',
        ]);
    }

    // public function filter_supplier_async(Request $request){
        
    //     $query = Product::query();

    //     if ($request->has('supplier_id') && Str::length((trim($request->supplier_id)))>0) {
    //         $query->where('supplier_id', $request->supplier_id);
    //     }

    //     $query = $query->whereRaw('stock <= minstock');
    
    //     $products = $query
    //         ->where('active',1)
    //         ->latest()
    //         ->get();
        
    //     return response()->json(
    //         [
    //             'products' => $products,
    //         ]
    //     );
        
    // }
    // public function filter_code_async(Request $request){
        
    //     $query = Product::query();

    //     if ($request->has('code') && Str::length((trim($request->code)))>0) {
    //         $query->where('code', 'like' ,'%'.$request->code.'%');
    //     }
    //     if ($request->has('supplier_id') && Str::length((trim($request->supplier_id)))>0) {
    //         $query->where('supplier_id', '=' ,$request->supplier_id);
    //     }
    
    //     $products = $query
    //         ->where('active',1)
    //         ->latest()
    //         ->get();
    //     return response()->json(
    //         [
    //             'products' => $products,
    //         ]
    //     );
        
    // }

    
    public function filter_async(Request $request){
        
        $query = Product::query();

        if ($request->has('code') && Str::length((trim($request->code)))>0) {
            $query->where('code', 'like' ,'%'.$request->code.'%');
        }
        if ($request->has('name') && Str::length((trim($request->name)))>0) {
            $query->where('name', 'like' ,'%'.$request->name.'%');
        }
        if ($request->has('supplier_id') && Str::length((trim($request->supplier_id)))>0) {
            $query->where('supplier_id', '=' ,$request->supplier_id);
        }
        if (Str::length((trim($request->code))) == 0 && Str::length((trim($request->name))) == 0 && Str::length((trim($request->supplier_id))) == 0) {
            $query->whereRaw('stock <= minstock');
        }
    
        $products = $query
            ->where('active',1)
            ->latest()
            ->get();
        return response()->json(
            [
                'products' => $products,
            ]
        );
        
    }

}

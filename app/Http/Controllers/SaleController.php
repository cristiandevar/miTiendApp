<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        $products = Product::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); 
        $users = User::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); 
            // Retornamos una vista y enviamos la variable 'sales'
        return view('panel.sales.crud.index', compact('sales', 'products', 'users'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un producto nuevo para cargarle datos
        $sale = new Sale();

        $today = date("d-m-Y");

        // Recuperamos todas las categorias de la BD
        $users = User::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get();

        return view('panel.sales.crud.create', compact('sale', 'users', 'today'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'date' => 'required',
            'user_id' => 'required'
        ]);

        $sale = new Sale();

        if ($request->get('active')) {
            $sale->active = 1;
        }
        else {
            $sale->active = 0;
        }
        $sale->user_id = $request->get('user_id');

        // Almacena la info del saleo en la BD
        $sale->save();

        return redirect()
            ->route('sale.index')
            ->with('alert', 'Venta nro:"' . $sale->id . '" agregada exitosamente.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return view('panel.sales.crud.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $users = User::where('active', 1)
        ->latest() //Ordena de manera DESC por el campo 'created_at'
        ->get();

        $today = $sale->created_at;
        return view('panel.sales.crud.edit', compact('sale', 'users', 'today'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            // 'date' => 'required',
            'user_id' => 'required'
        ]);

        if ($request->get('active')) {
            $sale->active = 1;
        }
        else {
            $sale->active = 0;
        }
        $sale->user_id = $request->get('user_id');

        // Almacena la info de la venta en la BD
        $sale->update();

        return redirect()
            ->route('sale.index')
            ->with('alert', 'Venta nro:"' . $sale->id . '" agregada exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->active = 0;
        
        $sale->update();

        return redirect()
            ->route('sale.index')
            ->with('alert', 'Venta "'.$sale->name.'" eliminada exitosamente.');
    
    }

    public function register_index(Request $request){
        $products = Product::where('active', 1)->latest()->get();
        $categories = Category::where('active', 1)->latest()->get();
        $suppliers = Supplier::where('active', 1)->latest()->get();
        return view('panel.sales.register.index', compact('products', 'categories', 'suppliers'));
    }

    public function register_action(Request $request) {
        $sale = new Sale();
        $sale->user_id = Auth::user()->id;
        $sale->save();
        
        for ($i = 0; $i<$request->qty;$i++){
            $r = $request->$i;
            $saledetail = new SaleDetail();
            $saledetail->sale_id = $sale->id;
            $saledetail->product_id = $r['product_id'];
            $saledetail->price = $r['price'];
            $saledetail->quantity = $r['quantity'];

            $product = Product::where('id',$r['product_id'])->first();
            // dd($product);
            $product->stock = $product->stock - $r['quantity'];
            $product->update();
            
            $saledetail->save();
        }

        return response()->json(
            [
                'products' => null
            ]
        );
    }
}

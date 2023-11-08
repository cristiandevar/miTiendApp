<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

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
        $employees = Employee::where('active', 1)
        ->latest() //Ordena de manera DESC por el campo 'created_at'
        ->get(); 
            // Retornamos una vista y enviamos la variable 'sales'
        return view('panel.sales.crud.index', compact('sales', 'products', 'employees'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un producto nuevo para cargarle datos
        $sale = new Sale();

        // Recuperamos todas las categorias de la BD
        $employees = Employee::where('active', 1)
        ->latest() //Ordena de manera DESC por el campo 'created_at'
        ->get();

        return view('panel.sales.crud.create', compact('sale', 'employees'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'employee_id' => 'required'
        ]);

        $sale = new Sale();

        if ($request->date) {
            $sale-> = $request->get('date');
        }

        if ($request->hasFile('image')) {
            // Subida de imagen al servidor (public > storage)
            $image_url = $request->file('image')->store('public/sale');
            $sale->image = asset(str_replace('public', 'storage', $image_url));
        }

        if ($request->get('active')) {
            $sale->active = 1;
        }
        else {
            $sale->active = 0;
        }
        
        $sale->name = $request->get('name');
        $sale->code = $request->get('code');
        $sale->price = $request->get('price');
        $sale->stock = $request->get('stock');
        $sale->category_id = $request->get('category_id');
        $sale->supplier_id = $request->get('supplier_id');

        // Almacena la info del saleo en la BD
        $sale->save();

        return redirect()
            ->route('sale.index')
            ->with('alert', 'saleo "' . $sale->name . '" agregado exitosamente.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        //
    }

    public function register(){
        return view('sales.');
    }
}

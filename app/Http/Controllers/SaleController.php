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

        $today = date("d-m-Y");

        // Recuperamos todas las categorias de la BD
        $employees = Employee::where('active', 1)
        ->latest() //Ordena de manera DESC por el campo 'created_at'
        ->get();

        return view('panel.sales.crud.create', compact('sale', 'employees', 'today'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'date' => 'required',
            'employee_id' => 'required'
        ]);

        $sale = new Sale();

        if ($request->get('active')) {
            $sale->active = 1;
        }
        else {
            $sale->active = 0;
        }
        $sale->employee_id = $request->get('employee_id');

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

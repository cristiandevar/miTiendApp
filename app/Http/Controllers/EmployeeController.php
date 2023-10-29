<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        
        $users = User::where('active', 1)->get();
        return view('panel.employees.crud.index', compact('employees', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Creamos un empleado nuevo para cargarle datos
        $employee = new Employee();
        // Recuperamos todas las categorias de la BD
        $users = User::get()->where('active', 1); // Recordar importar el modelo Categoria!!
        // Retornamos la vista de creacion de employeeos, enviamos el employeeo y las categorias
        return view('panel.employees.crud.create', compact('employee', 'users'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = new Employee();

        if ($request->has('email')) {
            $employee->email = $request->get('email');
        }

        if ($request->has('phone')) {
            $employee->phone = $request->get('phone');
        }
                
        $employee->lastname = $request->get('lastname');

        $employee->firstname = $request->get('firstname');

        $employee->dni = $request->get('dni');

        $employee->user_id = $request->get('user_id');
        
        // Almacena la info del employeeo en la BD
        $employee->save();

        return redirect()
            ->route('employee.index')
            ->with('alert', 'Empleado "' . $employee->name() . '" agregado exitosamente.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('panel.employees.crud.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $users = USer::where('active', 1)->get();
        
        return view('panel.employees.crud.edit', compact('employee', 'users'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $employee->lastname = $request->get('lastname');

        $employee->firstname = $request->get('firstname');

        $employee->dni = $request->get('dni');

        if ($request->has('email')) {
            $employee->email = $request->get('email');
        }

        if ($request->has('phone')) {
            $employee->phone = $request->get('phone');
        }

        $employee->user_id = $request->get('user_id');
        
        // Actualiza la info del employeeo en la BD
        $employee->update();

        return redirect()
            ->route('employee.index')
            ->with('alert', 'Empleado "' .$employee->name(). '" actualizado exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->active = 0;

        $employee->update();
        return redirect()
            ->route('employee.index')
            ->with('alert', 'Empleado "'.$employee->name().'" eliminado exitosamente');
    }
}

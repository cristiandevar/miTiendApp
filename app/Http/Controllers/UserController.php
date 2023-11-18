<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('active', 1)
            ->latest() //Ordena de manera DESC por el campo 'created_at'
            ->get(); //Convierte los datos extraidos de la BD en un array
        
        return view('panel.users.crud.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();
        $roles = Role::all();
        return view('panel.users.crud.create', compact('user','roles'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();

        $user->email = $request->get('email');

        $user->name = $request->get('name');
        
        $user->password = Hash::make($request->get('password'));
        
        $user->email_verified_at = now();

        $user->remember_token = Str::random(10);

        $user->assignRole(Role::find($request->get('role_id')));
        
        $user->save();

        return redirect()
            ->route('user.index')
            ->with('alert', 'Usuario "' . $user->name . '" agregado exitosamente.');
    
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('panel.users.crud.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        
        return view('panel.users.crud.edit', compact('user', 'roles'));    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->get('name');

        $user->email = $request->get('email');

        // $user->dni = $request->get('dni');

        // if ($request->has('email')) {
        //     $user->email = $request->get('email');
        // }

        // if ($request->has('phone')) {
        //     $user->phone = $request->get('phone');
        // }

        // $user->user_id = $request->get('user_id');
        $user->roles()->detach($request->get('role_id'));
        $user->assignRole(Role::find($request->get('role_id')));
        
        
        // Actualiza la info del employeeo en la BD
        $user->update();

        return redirect()
            ->route('user.index')
            ->with('alert', 'Usuario "' .$user->name. '" actualizado exitosamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->active = 0;

        $user->update();
        return redirect()
            ->route('User.index')
            ->with('alert', 'Empleado "'.$user->name().'" eliminado exitosamente');
    }
}

@extends('adminlte::page')

@section('title', 'Ver Empleado')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos del Empleado "{{ $employee->name() }}"</h1>
            <form action="{{ route('employee.destroy', $employee) }}" method="POST">
                <a href="{{ route('employee.index') }}" class="btn btn-sm btn-secondary col-xs-12 col-1 text-uppercase">
                    Volver
                </a>
                <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-sm btn-secondary col-xs-12 col-1 text-uppercase">
                    Editar
                </a>
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger text-uppercase me-1 m-1">
                    Eliminar
                </button>
            </form>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <h2>Nombre: {{ $employee->name() }}</h2>
                    </div>
                    <div class="mb-3">
                        <p> DNI: {{ $employee->dni }}</p>
                    </div>
                    <div class="mb-3">
                        <p> Email: {{ $employee->email }}</p>
                    </div>
                    <div class="mb-3">
                        <p> Telefono: {{ $employee->phone }}</p>
                    </div>
                    <div class="mb-3">
                        <p> Creación {{ $employee->created_at }}.</p>
                    </div>
                    <div class="mb-3">
                        <p> Modificación {{ $employee->updated_at }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')

@stop
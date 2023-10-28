{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Empleados')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Lista de Empleados</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            @if ($users->first())
                <a href="{{ route('employee.create') }}" class="btn btn-success text-uppercase">
                    Nuevo Empleado
                </a>
            @else
                <div>
                    <p>Ingrese primero un usuario desde <a href="{{ route('user.index') }}">aqui</a></p>
                </div>
            @endif
            
        </div>
        
        @if(session('alert'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('alert') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                    
                </div>
            </div>
        @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(count($employees)>0)
                    <table id="employees-table" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-uppercase">Nombre</th>
                                <th scope="col" class="text-uppercase">DNI</th>
                                <th scope="col" class="text-uppercase">Contacto</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employeess as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $name }}</td>
                                <td>{{ $employee->dni }}</td>
                                <td>{{ Str::limit($employee->contacto, 80) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('employee.show', $employee) }}" class="btn btn-sm btn-info text-white text-uppercase me-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('employee.edit', $employee) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('employee.destroy', $employee) }}" method="POST">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class='alert alert-danger small'>No tiene Empleados registrados</p>                    

                @endif
            </div>
        </div>
    </div>
</div>
@stop

{{-- Importacion de Archivos CSS --}}
@section('css')
    
@stop


{{-- Importacion de Archivos JS --}}
@section('js')

@stop
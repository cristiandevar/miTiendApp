{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Proveedores')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Lista de Proveedores</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            <a href="{{ route('supplier.create') }}" class="btn btn-success text-uppercase">
                Nuevo Proveedor
            </a>
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
                @if(count($suppliers)>0)
                    <table id="suppliers-table" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-uppercase">Nombre</th>
                                <th scope="col" class="text-uppercase">Dirección</th>
                                <th scope="col" class="text-uppercase">Contacto</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $supplier->id }}</td>
                                <td>{{ $supplier->companyname }}</td>
                                <td>{{ $supplier->address }}</td>
                                <td>
                                    @if ($supplier->email && $supplier->phone)
                                        <ul>
                                            <li>{{ Str::limit($supplier->email, 80) }}</li>
                                            <li>{{ Str::limit($supplier->phone, 80) }}</li>
                                        </ul>
                                    @else
                                        @if ($supplier->email)
                                            {{ Str::limit($supplier->email, 80) }}
                                        @endif
                                        @if ($supplier->phone)
                                            {{ Str::limit($supplier->phone, 80) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('supplier.show', $supplier) }}" class="btn btn-sm btn-info text-white text-uppercase me-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('supplier.edit', $supplier) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('supplier.destroy', $supplier) }}" method="POST">
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
                    <p class='alert alert-danger small'>No tiene Proveedores registrados</p>                    

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
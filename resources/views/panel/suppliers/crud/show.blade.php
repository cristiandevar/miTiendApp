@extends('adminlte::page')

@section('title', 'Ver Proveedor')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
        <form action="{{ route('supplier.destroy', $supplier) }}" method="POST">
            <h1>Datos del Proveedor "{{ $supplier->companyname }}"</h1>
            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary col-xs-12 col-1 text-uppercase">
                Volver
            </a>
            <a href="{{ route('supplier.show-edit', $supplier->id) }}" class="btn btn-sm btn-warning col-xs-12 col-1 text-uppercase">
                Editar
            </a>
            @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger text-uppercase m-1">
                    Eliminar
                </button>
            </form>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <p>Nombre: {{ $supplier->companyname }}</p>
                    </div>
                    <div class="mb-3">
                        <p> Email: <strong>{{ $supplier->email }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p> Telefono: <strong>{{ $supplier->phone }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p> Dirección: <strong>{{ $supplier->address }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p> Creación: <strong>{{ $supplier->created_at }}.</strong></strong>.</p>
                    </div>
                    <div class="mb-3">
                        <p> Modificación: <strong>{{ $supplier->updated_at }}.</strong></p>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('js/cruds/confirm-delete.js') }}"></script>

@stop
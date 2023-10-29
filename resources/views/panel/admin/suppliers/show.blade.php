@extends('adminlte::page')

@section('title', 'Ver Proveedor')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos del Proveedor "{{ $supplier->companyname }}"</h1>
            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-secondary col-xs-12 col-1 text-uppercase">
                Volver
            </a>
            <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-secondary col-xs-12 col-1 text-uppercase">
                Editar
            </a>
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
                        <p> Modificación: <strong>{{ $supplier->modified_at }}.</strong></p>
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
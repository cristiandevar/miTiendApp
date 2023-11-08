@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos de la Venta nro: "{{ $sale->id }}"</h1>
            <a href="{{ route('sale.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <h2>Nro: {{ $sale->id }}</h2>
                    </div>
                    <div class="mb-3">    
                        <h2>Fecha: {{ $sale->created_at }}</h2>
                    </div>
                    <div class="mb-3">
                        <p>cantidad de Productos: <strong>{{ $sale->qty_products }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>total: <strong>{{ $sale->total }}.</strong></p>
                    </div>
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
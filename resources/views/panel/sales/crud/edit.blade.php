@extends('adminlte::page')

@section('title', 'Editar')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Edición de la Venta "{{ $sale->name }}"</h1>
            
            @if(isset($back))
                <a href="{{ route('sale.show', $sale) }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver
                </a>
            @else
                <a href="{{ route('sale.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver al Listado
                </a> 
            @endif
        </div>
        <div class="col-12">
            @include('panel.sales.crud.forms.form')
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
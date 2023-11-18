@extends('adminlte::page')

@section('title', 'Editar')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Edición del Producto "{{ $product->name }}"</h1>
            @if(isset($back))
                <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver
                </a>
            @else
               <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver al Listado
                </a> 
            @endif
        </div>
        <div class="col-12">
            @include('panel.products.crud.forms.form')
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
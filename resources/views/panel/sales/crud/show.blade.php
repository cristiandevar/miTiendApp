@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos del Producto "{{ $product->name }}"</h1>
            <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;">
                    </div>
                    <div class="mb-3">    
                        <h2>Código: {{ $product->code }}</h2>
                    </div>
                    <div class="mb-3">    
                        <h2>Nombre: {{ $product->name }}</h2>
                    </div>
                    <div class="mb-3">
                        <p>Precio: <strong>{{ $product->price }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Stock: <strong>{{ $product->stock }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Categoria: <strong>{{ $product->category->name }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Proveedor: <strong>{{ $product->supplier->companyname }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Creación: <strong>{{ $product->created_at }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>total: <strong>
                            {{ 
                                
                                $sale->details->sum($sale->details->price * $sale->details->quantity ) 
                            
                            }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Descripción: <strong>{{ $product->description }}</strong></p>
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
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
                        <h2>Nombre: {{ $product->name }}</h2>
                    </div>
                    <div class="mb-3">
                        <p> Descripción: {{ $product->description }}</p>
                    </div>
                    <div class="mb-3">
                        <p>Precio: {{ $product->price }}</p>
                    </div>
                    <div class="mb-3">
                        <p>Categoria: {{ $product->category->name }}</p>
                    </div>
                    <div class="mb-3">
                        <p>Creado por {{ $product->seller->name }}.</p>
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
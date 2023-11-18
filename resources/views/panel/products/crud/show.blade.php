@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos del Producto "{{ $product->name }}"</h1>
            <form action="{{ route('product.destroy', $product) }}" method="POST">
                <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver al Listado
                </a>
                <input type="hidden" name="back" value="product.show"/>
                <input type="hidden" name="id" value="{{ $product->id }}"/>
                <a href="{{ route('product.show-edit', $product) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
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
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;">
                    </div>
                    <div class="mb-3">
                        <p>Precio: <strong>{{ $product->price }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Stock: <strong>{{ $product->stock }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Min. Stock: <strong>{{ $product->minstock }}.</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Categoria: <strong>{{ $product->category->name }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Proveedor: <strong>{{ $product->supplier->companyname }}</strong></p>
                    </div>
                    <div class="mb-3">    
                        <p>Código: <strong>{{ $product->code }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Creación: <strong>{{ $product->created_at }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Modificación: <strong>{{ $product->updated_at }}</strong></p>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('js/cruds/confirm-delete.js') }}"></script>
@stop
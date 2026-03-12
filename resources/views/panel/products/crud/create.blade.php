@extends('adminlte::page')

@section('title', 'Crear Producto')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        
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

    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="error">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                    
            </div>
        </div>
    @endif
        <div class="col-12 mb-3">
            <h1>Creación de un nuevo Producto</h1>
            <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
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
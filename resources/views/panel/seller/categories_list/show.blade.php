@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos de la Categoria "{{ $category->name }}"</h1>
            <a href="{{ route('category.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <h2>Nombre: {{ $category->name }}</h2>
                    </div>
                    <div class="mb-3">
                        <p>Cantidad productos asociados:<strong> {{ $category->products->count() }} </strong>.</p>
                    </div>
                    <div class="mb-3">
                        <p>Creado por <strong>{{ $category->seller->name }} </strong>.</p>
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
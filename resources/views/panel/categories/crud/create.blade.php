@extends('adminlte::page')

@section('title', 'Crear Categoria')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Creación de un nueva Categoria</h1>
            <a href="{{ route('category.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
        </div>

        <div class="col-12">
            @include('panel.categories.crud.forms.form')
        </div>

    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
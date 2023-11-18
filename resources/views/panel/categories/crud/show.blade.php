@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos de la Categoria "{{ $category->name }}"</h1>
            <form action="{{ route('category.destroy', $category) }}" method="POST">
                <a href="{{ route('category.index') }}" class="btn btn-sm btn-secondary text-uppercase me-1 m-1">
                    Volver al Listado
                </a>
                
                <a href="{{ route('category.show-edit', $category) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                    Editar
                </a>
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger text-uppercase me-1 m-1">
                    Eliminar
                </button>
            </form>
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
                        <p>Creación <strong>{{ $category->created_at }} </strong>.</p>
                    </div>
                    <div class="mb-3">
                        <p>Modificación <strong>{{ $category->updated_at }} </strong>.</p>
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
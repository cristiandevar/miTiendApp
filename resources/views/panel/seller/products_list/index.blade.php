{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Productos')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Lista de Productos</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            @if ($categories->first())
                <a href="{{ route('product.create') }}" class="btn btn-success text-uppercase">
                    Nuevo Producto
                </a>
            @else
                <div>
                    <p>Ingrese primero una categoria</p>
                    <a href="{{ route('category.index') }}" class="btn btn-success text-uppercase">
                        Ir a categorias
                    </a>
                
                </div>
            @endif
            
        </div>
        
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

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(count($products)>0)
                    <table id="tabla-productos" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-uppercase">Categoría</th>
                                <th scope="col" class="text-uppercase">Nombre</th>
                                <th scope="col" class="text-uppercase">Descripción</th>
                                <th scope="col" class="text-uppercase">Imagen</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ Str::limit($product->description, 80) }}</td>
                                <td>
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('product.show', $product) }}" class="btn btn-sm btn-info text-white text-uppercase me-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('product.edit', $product) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('product.destroy', $product) }}" method="POST">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-uppercase">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class='alert alert-danger small'>No tiene productos registrados</p>                    

                @endif
            </div>
        </div>
    </div>
</div>
@stop

{{-- Importacion de Archivos CSS --}}
@section('css')
    
@stop


{{-- Importacion de Archivos JS --}}
@section('js')

@stop
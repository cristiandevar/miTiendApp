{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Productos Filtrados')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Filtro de Productos</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            @if (!$categories->first())
                <div>
                    <p>Ingrese primero una categoria desde <a href="{{ route('category.index') }}">aqui</a></p>
                </div>
            @endif
            @if (!$suppliers->first())
                <div>
                    <p>Ingrese primero un Proveedor desde <a href="{{ route('supplier.index') }}">aqui</a></p>
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

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('product.filter') }}" method='GET'>
                    <div class="form-group row">
                        <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                        <select id="supplier_id" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
                            <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
                            @foreach ($suppliers as $supplier)
                                <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                    {{ $supplier->companyname }}
                                </option>
                            @endforeach
                        </select>
                        <select id="category_id" name="category_id" class="form-control col-xs-12 col-2 m-1">
                            <option value=""  {{ !isset($inputs['category_id'])? 'selected':''}}>Categoria...</option>
                            @foreach ($categories as $category)
                                <option {{ isset($inputs['category_id']) && $inputs['category_id'] == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input class="form-control col-xs-12 col-2 m-1" type="number" id="price_since" name="price_since" placeholder="Precio desde..." value={{ isset($inputs['price_since'])? $inputs['price_since'] : '' }}>
                        <input class="form-control col-xs-12 col-2 m-1" type="number" id="price_to" name="price_to" placeholder="Precio hasta..." value={{ isset($inputs['price_to'])? $inputs['price_to'] : '' }}>
                        <input class="form-control col-xs-12 col-2 m-1" type="date" id="date_since" name="date_since" placeholder="Fecha desde..." value={{ isset($inputs['date_since'])? $inputs['date_since'] : '' }}>
                        <input class="form-control col-xs-12 col-2 m-1" type="date" id="date_to" name="date_to" placeholder="Fecha hasta..." value={{ isset($inputs['date_to'])? $inputs['date_to'] : '' }}>
                    </div>
                    <button type="submit" class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                        Filtrar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(count($products)>0)
                    <table id="tabla-productos" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-uppercase">Nombre</th>
                                <th scope="col" class="text-uppercase">Categoría</th>
                                <th scope="col" class="text-uppercase">Proveedor</th>
                                <th scope="col" class="text-uppercase">Imagen</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->supplier->companyname }}</td>
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
                    <p class='alert alert-danger small'>Ningun producto coincide</p>                    

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
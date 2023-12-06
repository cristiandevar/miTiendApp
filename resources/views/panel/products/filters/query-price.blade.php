{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Productos Filtrados')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Consulta de Productos</h1>
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
                <div class="alert alert-success alert-dismissible show" role="alert">
                    {{ session('alert') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                    
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible show" role="error">
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
                    <form action="{{ route('product.filter') }}" method='GET' id="form-filter">
                        <h6 class="card-header">Consulte por nombre y/o código</h6>
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre..." value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código..." value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="number" id="stock_since" name="stock_since" placeholder="Stock desde..." value={{ isset($inputs) && isset($inputs['stock_since'])? $inputs['stock_since'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="number" id="stock_to" name="stock_to" placeholder="Stock hasta..." value={{ isset($inputs) && isset($inputs['stock_to'])? $inputs['stock_to'] : '' }}>
                        </div>
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="number" id="price_since" name="price_since" placeholder="Precio desde..." value={{ isset($inputs) && isset($inputs['price_since'])? $inputs['price_since'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="number" id="price_to" name="price_to" placeholder="Precio hasta..." value={{ isset($inputs) && isset($inputs['price_to'])? $inputs['price_to'] : '' }}>
                            
                            {{-- <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-3 m-1 btn btn-success text-uppercase">
                                Consultar
                            </button> --}}
                        </div>
                        <h6 class="card-header">Elija el criterio de ordenamiento</h6>
                        <div class="form-group row">
                            <select title="Ordenar por..." id="order-by-1" name="order_by_1" class="form-control col-xs-12 col-2 m-1">
                                {{-- <option value="created_at" selected>Fecha de creación</option>
                                <option value="code">Código</option> --}}
                                <option value="name"selected>Nombre</option>
                                <option value="price">Precio</option>
                                <option value="stock">Stock</option>
                                {{-- <option value="category">Categoria</option>
                                <option value="supplier">Proveedor</option> --}}
                            </select>
                            <select title="Ordenar de forma..." id="order-by-2" name="order_by_2" class="form-control col-xs-12 col-2 m-1">
                                <option value="asc" selected>Ascendente</option>
                                <option value="desc">Descendente</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="card-table">
                    @if(count($products)>0)
                        {{-- @include('panel.products.tables.table-main') --}}
                        <div id='alert-table'>
                            <p class='alert alert-danger small'>Ningun producto coincide</p>`
                        </div>
                        <table class="table table-striped table-hover w-100" id="table-products">
                            <thead id="thead-products">
                                <tr>
                                    <th scope="col" class="text-uppercase">Imagen</th>
                                    <th scope="col" class="text-uppercase">nombre</th>
                                    <th scope="col" class="text-uppercase">precio</th>
                                    <th scope="col" class="text-uppercase">stock</th>
                                    {{-- <th scope="col" class="text-uppercase">IMAGEN</th> --}}
                                </tr>
                            </thead>
                            <tbody id="tbody-products">
                                @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    
                                    {{-- <td>
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
                                    </td> --}}
                                    {{-- <td><a href="{{ route('product.show', $product->id) }}">{{ $product->code }}</a></td> --}}
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class='alert alert-danger small'>No tiene productos cargados</p>                    
                    @endif
                </div>
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
<script src="{{ asset('js/products/filters/create-table-query-products.js') }}"></script>
<script src="{{ asset('js/products/filters/filter-products.js') }}"></script>
{{-- <script src="{{ '/storage/js/panel/products/filters/update-price-products.js' }}"></script> --}}
@stop


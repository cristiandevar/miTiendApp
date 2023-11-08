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
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código..." value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre..." value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            {{-- <select id="supplier_id" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
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
                            </select> --}}
                            <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-1 m-1 btn btn-success text-uppercase">
                                Consultar
                            </button>
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
                                    <th scope="col" class="text-uppercase">PRECIO</th>
                                    <th scope="col" class="text-uppercase">NOMBRE</th>
                                    <th scope="col" class="text-uppercase">CÓDIGO</th>
                                    {{-- <th scope="col" class="text-uppercase">IMAGEN</th> --}}
                                </tr>
                            </thead>
                            <tbody id="tbody-products">
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->code }}</td>
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


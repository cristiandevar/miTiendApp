@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Registrar Venta')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Registre su Venta</h1>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- <div class="col-12 mb-3">
            
            @if ($products->first())
                <a href="{{ route('sale.create') }}" class="btn btn-success btn-sm text-uppercase">
                    Nueva Venta
                </a>
            @else
                <div>
                    <p>Ingrese primero un Producto desde <a href="{{ route('product.index') }}">aqui</a></p>
                </div>             
            @endif
        </div> --}}
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
                <h5 class="card-header">Elija sus productos</h5>
                <div class="card-body">
                    <form id="form-filter" action="#" method='GET'>
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código" value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
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
                            <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                                Filtrar
                            </button>
                        </div>
                    </form>
                {{-- </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="card-table"> --}}
                    <form action="#" method="get">
                        <div class="form-group row" style='height:15em;overflow-y:auto;'>
                            @if(count($products)>0)
                                {{-- @include('panel.products.tables.table-main') --}}
                                <div id='alert-table'>
                                    <p class='alert alert-danger small'>Ningun producto coincide</p>`
                                </div>
                                
                                    <table id="table-products" class="table table-sm table-striped table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-uppercase">Código</th>
                                                <th scope="col" class="text-uppercase">Nombre</th>
                                                <th scope="col" class="text-uppercase">Precio</th>
                                                <th scope="col" class="text-uppercase">Cantidad</th>
                                                {{-- <th scope="col" class="text-uppercase">Categoría</th>
                                                <th scope="col" class="text-uppercase">Proveedor</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-products">
                                            @foreach ($products as $product)
                                            <tr id='{{ "trproduct-".$product->id}}'>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td><input type="number" name='{{ "qty-".$product->id }}' id='{{ "qty-".$product->id }}'></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            @else
                                <p class='alert alert-danger small'>No tiene productos cargados</p>                    
                            @endif
                        </div>
                        <button id='add-products' class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                            Agregar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Detalles de venta</h5>
                <form action="#" method="post">
                    <div class="card-body" id="card-table">
                        <div class="form-group row" style='height:15em;overflow-y:auto;'>
                            <table id="table-sale" class="table table-sm table-striped table-hover w-100">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-uppercase">Código</th>
                                        <th scope="col" class="text-uppercase">Nombre</th>
                                        <th scope="col" class="text-uppercase">Precio</th>
                                        <th scope="col" class="text-uppercase">Cantidad</th>
                                        <th scope="col" class="text-uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-sale">
                                    <tr id="trsale-total">
                                        <th>Total</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button id='add-sale' class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase" >
                            Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>




    </div>
</div>


@stop

{{-- Importacion de Archivos JS --}}
@section('js')
{{-- <script type="text/javascript" src="{{ asset('products/js/create-table-filter-products.js') }}"></script> --}}

<script type="text/javascript" src="{{ asset('js/sales/filters/create-table-sale-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/filters/filter-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/add-products-checked.js') }}"></script>
@stop
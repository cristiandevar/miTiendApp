@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Generar Orden de Compra')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Genere su Orden</h1>
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
        <div id="div-alert-1" class="col-12">
            <div class="alert alert-success alert-dismissible show" role="alert">
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                    
            </div>
        </div>

        
        <div id="div-error-1" class="col-12">
            <div class="alert alert-danger alert-dismissible show" role="error">
                
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>                    
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-header">Elija su Proveedor</h6>
                    <form id="form-1" action="#" method='GET'>
                        <div class="form-group row">
                            <select id="select-supplier" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
                                <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                        {{ $supplier->companyname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <h6 class="card-header col-4 col-xs-12">Agregue sus productos</h6>
                        
                        <div class="form-group row">
                            <input id="input-code-1" type="text" class="form-control col-2 m-1" placeholder="Código.."/>
                            <input id="input-name-1" type="text" class="form-control col-2 m-1" placeholder="Nombre.." />
                            <input id="input-stock-1" type="text" class="form-control col-2 m-1" placeholder="Stock.." disabled/>
                            <input id="input-stock-2" type="number" class="form-control col-2 m-1" placeholder="Solicitar.."/>
                            <a id="add-row-1" class="btn btn-primary col-2 m-1">+</a>
                            <div id='alert-table-options'>
                                <p class='alert alert-danger small'>Ningun producto elegido/sugerido</p>`
                            </div>
                            <table id="table-options-1" class="table table-sm table-striped table-hover w-100 col-12">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Nombre</th>
                                        <th>Stock Actual</th>
                                        <th>Stock Minimo</th>
                                        <th>Stock Sugerido</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-options">

                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="row">
                        <h6 class="card-header col-4 col-xs-12">Productos Elegidos/Sugeridos</h6>
                        <button id='add-purchase' class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase" >
                            Generar
                        </button>
                    </div>
                    <form id="form-2" action="#" method="post">
                        <div class="card-body" id="card-table">
                            <div class="form-group row" style='height:15em;overflow-y:auto;'>
                                <div id='alert-table-purchase'>
                                    <p class='alert alert-danger small'>Ningun producto elegido/sugerido</p>`
                                </div>
                                <table id="table-purchase" class="table table-sm table-striped table-hover w-100">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-uppercase">Código</th>
                                            <th scope="col" class="text-uppercase">Nombre</th>
                                            <th scope="col" class="text-uppercase">Stock Actual</th>
                                            <th scope="col" class="text-uppercase">Cant. a pedir</th>
                                            <th scope="col" class="text-uppercase">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-purchase">
                                        @foreach($products as $product)
                                            <tr id='{{ "trproduct-".$product->id}}'>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->stock }}</td>
                                                <td>{{ $product->minstock }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </form>
                </div>
                {{-- <h5 class="card-header">Elija sus Productos</h5>
                <div class="card-body">
                    <form id="form-filter-2" action="#" method='GET'>
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código" value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
                            <select id="category_id" name="category_id" class="form-control col-xs-12 col-2 m-1">
                                <option value=""  {{ !isset($inputs['category_id'])? 'selected':''}}>Categoria...</option>
                                @foreach ($categories as $category)
                                    <option {{ isset($inputs['category_id']) && $inputs['category_id'] == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div> --}}
            </div>
        </div>
        
        {{-- <div class="col-12">
            <div class="card">
                <div class="card-body" id="card-table">
                    <form action="#" method="get" novalidate>
                        <div class="form-group row" style='height:15em;overflow-y:auto;'>
                            @if(count($products)>0)
                                 @include('panel.products.tables.table-main')
                                
                                
                                    <table id="table-products" class="table table-sm table-striped table-hover w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-uppercase">Código</th>
                                                <th scope="col" class="text-uppercase">Nombre</th>
                                                <th scope="col" class="text-uppercase">Precio</th>
                                                <th scope="col" class="text-uppercase">Cantidad</th>
                                                {{-- <th scope="col" class="text-uppercase">Categoría</th>
                                                <th scope="col" class="text-uppercase">Proveedor</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody-products">
                                            @foreach ($products as $product)
                                            <tr id='{{ "trproduct-".$product->id}}'>
                                                <td>{{ $product->code }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>
                                                    <input type="number" name='{{ "qty-".$product->id }}' id='{{ "qty-".$product->id }}'><br>
                                                    <span id='{{"sp-".$product->id }}' class="error" aria-live="polite"></span>
                                                </td>
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
                                        <th scope="col"></th>
                                        <th scope="col" class="text-uppercase">Código</th>
                                        <th scope="col" class="text-uppercase">Nombre</th>
                                        <th scope="col" class="text-uppercase">Precio</th>
                                        <th scope="col" class="text-uppercase">Cantidad</th>
                                        <th scope="col" class="text-uppercase">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-sale">
                                    <tr id="trsale-total" style="border-top:solid 1px;">
                                        <th>Total</th>
                                        <td></td>
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
        </div> --}}




    </div>
</div>


@stop

@section('css')
{{-- <link rel="stylesheet" href="{{ asset('css/sales/register/controller-stock-products.css')}}" > --}}
@stop


{{-- Importacion de Archivos JS --}}
@section('js')
{{-- <script type="text/javascript" src="{{ asset('products/js/create-table-filter-products.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('js/purchases/generate/create-table-purchase-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/generate/generate-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/filters/filter-products.js') }}"></script>

{{-- <script type="text/javascript" src="{{ asset('js/sales/filters/create-table-sale-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/filters/filter-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/add-products-checked.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/register-sale.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/controller-stock-products.js') }}"></script> --}}
@stop
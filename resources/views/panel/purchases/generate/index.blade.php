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
                    {{-- <h6 class="card-header">Elija su Proveedor</h6> --}}
                    <form id="form-filter" action="#" method='GET'>
                        <div id="fields-filter">
                            {{-- <div class="form-group row">
                                <select id="select-supplier" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
                                    <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
                                    @foreach ($suppliers as $supplier)
                                        <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                            {{ $supplier->companyname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <h6 class="card-header col-4 col-xs-12">Filtre sus productos</h6>
                            <div class="form-group row">
                                <input id="code" name="code" type="text" class="form-control col-2 m-1" placeholder="Código.."/>
                                <input id="name" name="name" type="text" class="form-control col-2 m-1" placeholder="Nombre.." />
                                <select id="select-category" name="category_id" class="form-control col-xs-12 col-2 m-1">
                                    <option value="" {{ !isset($inputs['category_id']) || $inputs['category_id']==''? 'selected':''}}>Categoria...</option>
                                    @foreach ($categories as $category)
                                        <option {{ isset($inputs['category_id']) && $inputs['category_id'] == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                <select id="select-supplier" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
                                    <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
                                    @foreach ($suppliers as $supplier)
                                        <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                            {{ $supplier->companyname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row">
                                <input class="form-control col-xs-12 col-2 m-1" type="number" id="stock_since" name="stock_since" placeholder="Stock desde..." value={{ isset($inputs) && isset($inputs['stock_since'])? $inputs['stock_since'] : '' }}>
                                <input class="form-control col-xs-12 col-2 m-1" type="number" id="stock_to" name="stock_to" placeholder="Stock hasta..." value={{ isset($inputs) && isset($inputs['stock_to'])? $inputs['stock_to'] : '' }}>
                            </div>
                            <h6 class="card-header col-4 col-xs-12">Ordene los productos</h6>
                            <div class="form-group row">
                                <select title="Ordenar por..." id="order-by-1" name="order_by_1" class="form-control col-xs-12 col-2 m-1">
                                    <option value="created_at" selected>Fecha de creación</option>
                                    <option value="code">Código</option>
                                    <option value="name">Nombre</option>
                                    <option value="price">Precio</option>
                                    <option value="stock">Stock</option>
                                    <option value="category">Categoria</option>
                                    <option value="supplier">Proveedor</option>
                                </select>
                                <select title="Ordenar de forma..." id="order-by-2" name="order_by_2" class="form-control col-xs-12 col-2 m-1">
                                    <option value="asc" selected>Ascendente</option>
                                    <option value="desc">Descendente</option>
                                </select>
                            </div>
                            <h6 class="card-header col-4 col-xs-12">Agregue los productos</h6>
                            <div class="form-group row">
                                <button id="add-row-1" class="btn btn-primary col-2 m-1">Agregar</button>
                                <input class="form-control col-2 col-xs-12 m-1" type="number" id="-qtyall" name="all-qty" placeholder="Cant a todos..." title="Aplicar cantidad a todos">      
                                <div class="col-2 col-xs-12 m-1">
                                    <span id='sp-qtyall' class="error" aria-live="polite" style="width: 0%;"></span>
                                </div>    
                            </div>
                        </div>
                        
                        <div class="form-group" style='height:15em;overflow-y:auto;'>
                            <div id='alert-table-options'>
                                <p class='alert alert-danger small'>Ningun producto coincide con la busqueda</p>`
                            </div>
                            <table id="table-options-1" class="table table-sm table-striped table-bordered table-hover ">
                                <thead style="position: sticky; top: 0;background-color:white;">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Proveedor</th>
                                        <th>Stock Actual</th>
                                        <th>Cant. a pedir</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-options">
                                    @foreach($products as $product)
                                        <tr id='{{ "trproduct-".$product->id}}'>
                                            <td>{{ $product->code }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->supplier->companyname }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <input id={{ "qty-".$product->id }} type='number'/><br>
                                                <span id='{{"sp-".$product->id }}' class="error" aria-live="polite"></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <form id="form-voucher" action="{{ route('purchase.export-many-file') }}" method="get">
                        <div class="row">
                            <h6 class="card-header col-4 col-xs-12">Productos Elegidos</h6>
                            <button type="submit" id='add-purchase' class="form-control col-xs-12 col-3 m-1 btn btn-success text-uppercase" >
                                Generar Orden/es
                            </button>
                            <button id='add-other' class="form-control col-xs-12 col-3 m-1 btn btn-primary col-2 m-1" >
                                Agrega otro
                            </button>
                        </div>
                    </form>
                    <form id="form-2" action="#" method="post">
                        <div class="card-body" id="card-table">
                            <div id='alert-table-purchase'>
                                <p class='alert alert-danger small'>Ningun producto elegido/sugerido</p>`
                            </div>
                            <div class="form-group row" style='height:15em;overflow-y:auto;'>
                                <table id="table-purchase" class="table table-sm table-striped table-hover w-100">
                                    <thead style="position: sticky; top: 0;background-color:white;">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col" class="text-uppercase">Código</th>
                                            <th scope="col" class="text-uppercase">Nombre</th>
                                            <th scope="col" class="text-uppercase">Proveedor</th>
                                            <th scope="col" class="text-uppercase">Stock Actual</th>
                                            <th scope="col" class="text-uppercase">Cant. a pedir</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-purchase">
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/error/span-error.css')}}" >
{{-- <link rel="stylesheet" href="{{ asset('css/loading/loading-spin.css')}}" > --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> --}}
@stop


{{-- Importacion de Archivos JS --}}
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('js/purchases/generate/create-table-purchase-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/generate/generate-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/filters/filter-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/filters/add-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweet-alert/sweet-alert.js') }}"></script>
@stop
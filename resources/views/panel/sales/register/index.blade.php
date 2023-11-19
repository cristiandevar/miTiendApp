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
                <h5 class="card-header">Elija sus productos</h5>
                <div class="card-body">
                    <form id="form-filter" action="#" method='GET'>
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código" value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
                            
                            {{-- <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                                Filtrar
                            </button> --}}
                            
                            
                        </div>
                    </form>
                {{-- </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="card-table"> --}}
                    <form action="#" method="get" novalidate>
                        <div class="form-group row" style='height:15em;overflow-y:auto;'>
                            <button id='add-products' class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                                Agregar
                            </button>
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
        </div>




    </div>
</div>


@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/sales/register/controller-stock-products.css')}}" >
@stop


{{-- Importacion de Archivos JS --}}
@section('js')
{{-- <script type="text/javascript" src="{{ asset('products/js/create-table-filter-products.js') }}"></script> --}}

<script type="text/javascript" src="{{ asset('js/sales/filters/create-table-sale-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/filters/filter-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/add-products-checked.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/register-sale.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sales/register/controller-stock-products.js') }}"></script>
@stop
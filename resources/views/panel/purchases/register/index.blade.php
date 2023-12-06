@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Generar Orden de Compra')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Registre su Orden</h1>
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
                <p id="p-error"></p>
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
                            
                            <input title="Ingrese Fecha desde" class="form-control col-xs-12 col-2 m-1" type="date" id="date_since" name="date_since" placeholder="Fecha desde..." value={{ isset($inputs['date_since'])? $inputs['date_since'] : '' }}>
                            <input title="Ingrese Fecha hasta" class="form-control col-xs-12 col-2 m-1" type="date" id="date_to" name="date_to" placeholder="Fecha hasta..." value={{ isset($inputs['date_to'])? $inputs['date_to'] : '' }}>
                        </div>
                        <h6 class="card-header col-4 col-xs-12">Elija la orden de compra</h6>
                            {{-- <div class="form-group row">
                                <input id="input-code-1" type="text" class="form-control col-3 m-1" placeholder="Código.."/>
                                <input id="input-name-1" type="text" class="form-control col-3 m-1" placeholder="Nombre.." />
                                <a id="add-row-1" class="btn btn-primary col-2 m-1">Agregar</a>
                            </div> --}}
                            <div class="form-group" style='height:15em;overflow-y:auto;'>
                                <div id='alert-table-purchases-1'>
                                    <p class='alert alert-danger small'>No hay ordenes de compra registradas o asociadas </p>`
                                </div>
                                <table id="table-purchases-1" class="table table-sm table-striped table-hover w-100 col-12">
                                    <thead style="position: sticky; top: 0;background-color:white;">
                                        <tr>
                                            <th scope="col" class="text-uppercase">Nro</th>
                                            <th scope="col" class="text-uppercase">Proveedor</th>
                                            <th scope="col" class="text-uppercase">Fecha Emisión</th>
                                            <th scope="col" class="text-uppercase">Acciónes</th>
                                            <th ></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-purchases-1">
                                        @foreach($purchases as $purchase)
                                            <tr id='{{ "trpurchase-".$purchase->id}}'>
                                                <td>{{ $purchase->id }}</td>
                                                <td>{{ $purchase->supplier->companyname }}</td>
                                                <td>{{ $purchase->created_at->format('d/m/Y h:i:s') }}</td>
                                                <td>
                                                    <a id={{'linkr-'.$purchase->id}} href="#" title="Registrar compra"><i class="fas fa-check-square" style="color: #05ff37;"></i></a>
                                                    <a id={{'linke-'.$purchase->id}} href="#" title="Modificar compra"><i class="fas fa-pen-square" style="color: #e2dc12;"></i></a>
                                                    <a id={{'linkd-'.$purchase->id}} href="#" title="Cancelar compra"><i class="fas fa-window-close" style="color: #ff0000;"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    <h6 class="card-header">Detalles de la compra</h6>
                    <form id="form-register-purchase">
                        <div class="form-group row">
                            <label for="total-price-input" class="col-form-label">* Total pagado</label>
                            <input id="total-price-input" type="number" class="form-control col-xs-12 col-3 m-1" placeholder="Total pagado..." />
                            
                            <button id='register-purchase' class="form-control col-xs-12 col-3 m-1 btn btn-success text-uppercase" >
                                Registrar Orden
                            </button>
                        </div>
                        <div class="form-group" style='height:15em;overflow-y:auto;'>
                            <div id='alert-table-purchases-2'>
                                <p class='alert alert-danger small'>No hay detalles asociados a la orden </p>`
                            </div>
                            <table id="table-purchases-2" class="table table-sm table-striped table-hover w-100 col-12">
                                <thead style="position: sticky; top: 0;background-color:white;">
                                    <tr>
                                        <th>Nro</th>
                                        <th>Producto</th>
                                        <th>Cant. Pedida</th>
                                        <th>Cant. Recibida</th>
                                        <th>Precio costo</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-purchases-2">
                                    
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <form id="form-update-purchase">
                        <div class="form-group row">
                            {{-- <label for="total-price-input" class="col-form-label">* Total pagado</label>
                            <input id="total-price-input" type="number" class="form-control col-xs-12 col-3 m-1" placeholder="Total pagado..." />
                             --}}
                            <button id='update-purchase' class="form-control col-xs-12 col-3 m-1 btn btn-success text-uppercase" >
                                Modificar Orden
                            </button>
                        </div>
                        <div id='alert-table-purchases-3'>
                            <p class='alert alert-danger small'>No hay detalles asociados a la orden </p>`
                        </div>
                        <div class="form-group" style='height:15em;overflow-y:auto;'>
                            
                            <table id="table-purchases-3" class="table table-sm table-striped table-hover w-100 col-12">
                                <thead style="position: sticky; top: 0;background-color:white;">
                                    <tr>
                                        <th></th>
                                        <th>Producto</th>
                                        <th>Stock Actual</th>
                                        <th>Cant. Pedida</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-purchases-3">
                                    
                                </tbody>
                            </table>
                            
                        </div>
                        <div id='alert-table-purchases-4'>
                            <p class='alert alert-danger small'> </p>`
                        </div>
                    </form>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- <script type="text/javascript" src="{{ asset('js/purchases/generate/create-table-purchase-products.js') }}"></script> --}}
<script type="text/javascript" src="{{ asset('js/purchases/register/register-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/register/register-action.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/update/update-index.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/update/update-action.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweet-alert/sweet-alert.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('js/purchases/filters/filter-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/purchases/filters/add-products.js') }}"></script> --}}
@stop
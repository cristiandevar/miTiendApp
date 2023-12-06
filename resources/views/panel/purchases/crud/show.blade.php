@extends('adminlte::page')

@section('title', 'Ver Compra')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <h1>Datos de la Compra nro: "{{ $purchase->id }}"</h1>
        <div class="col-10 mb-3">
            <form action="{{ route('purchase.destroy', $purchase) }}" method="POST">
                <a href="{{ route('purchase.index') }}" class="btn btn-sm btn-secondary text-uppercase me-1 m-1">
                    Volver al Listado
                </a>
                {{-- <a href="{{ route('purchase.show-edit', $purchase) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                    Editar
                </a> --}}
                @csrf 
                @method('DELETE')
                <button id="del-purchase" type="submit" class="btn btn-sm btn-danger text-uppercase m-1">
                    Cancelar Compra
                </button>
            </form>
        </div>
        
        <div class="col-2 mb-3">
            <form id="form-export" action="{{ route('purchase.export-file') }}" method='GET'>
                {{-- <h6 class="card-header">Descargue s</h6> --}}
                
                {{-- <button id="btn-excel-1" type="submit" name="action" value="excel" class="form-control col-xs-12 col-1 m-1 btn btn-success "title="Exportar datos filtrados en formato .XLSX"><i class="fas fa-file-excel"></i>
                </button> --}}
                <input type="hidden" name="purchase_id" id="purchase_id" value="{{ $purchase->id}}"/>
                <button id="btn-pdf-1" type="submit" name="action" value="pdf" class="form-control btn btn-success "title="Descargar comprobante en formato .PDF"><i class="fas fa-file-pdf"></i>
                </button>
            </form>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <p>Nro: {{ $purchase->id }}</p>
                    </div>
                    <div class="mb-3">    
                        <p>Fecha Emisión: {{ $purchase->created_at }}<p>
                    </div>
                    <div class="mb-3">
                        <p>Fecha Recepción: <strong>{{ $purchase->received_date}}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>Total pagado: <strong>{{ $purchase->total_paid }}</strong></p>
                    </div>
                    </div>
                </div>
                
            </div>
            <div class="card">
                <h3>Detalles de la compra</h3>
                <div class="card-body">
                    {{-- <a href="{{ route('purchasedetail.create', $purchase) }}" class="btn btn-success btn-sm text-uppercase">
                        Nuevo Detalle
                    </a> --}}
                    @if($purchase->details->count()>0)
                    <table id="tabla-purchase-details" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col" class="text-uppercase">Nro</th>
                                <th scope="col" class="text-uppercase">Producto</th>
                                <th scope="col" class="text-uppercase">Cant. Pedida</th>
                                <th scope="col" class="text-uppercase">Cant. Recibida</th>
                                <th scope="col" class="text-uppercase">Precio Costo</th>
                                {{-- <th scope="col" class="text-uppercase">Opciones</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->details as $key => $detail)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity_ordered }}</td>
                                <td>{{ $detail->quantity_received }}</td>
                                <td>{{ $detail->cost_price }}</td>
                                {{-- <td>
                                    <div class="d-flex">
                                        <a href="{{ route('purchasedetail.show', $detail) }}" class="btn btn-sm btn-info text-white text-uppercase me-1 m-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('purchasedetail.edit', $detail) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('purchasedetail.destroy', $detail) }}" method="POST">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-uppercase m-1">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class='alert alert-danger small'>No tiene Detalles registrados</p>                    

                @endif
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
@extends('adminlte::page')

@section('title', 'Ver')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos de la Venta nro: "{{ $sale->id }}"</h1>
            <form action="{{ route('sale.destroy', $sale) }}" method="POST">
                <a href="{{ route('sale.index') }}" class="btn btn-sm btn-secondary text-uppercase me-1 m-1">
                    Volver al Listado
                </a>
                <a href="{{ route('sale.edit', $sale) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                    Editar
                </a>
            
                @csrf 
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger text-uppercase me-1 m-1">
                    Eliminar
                </button>
            </form>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <p>Nro: {{ $sale->id }}</p>
                    </div>
                    <div class="mb-3">    
                        <p>Fecha: {{ $sale->created_at }}<p>
                    </div>
                    <div class="mb-3">
                        <p>cantidad de Productos: <strong>{{ $sale->details->count() }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>total: <strong>
                            <?php 
                                $acum = 0;
                                foreach ($sale->details as $detail){
                                    $acum += $detail->price * $detail->quantity;
                                }
                                echo $acum;                      
                            ?>.</strong></p>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <h3>Detalles de la venta</h3>
                <div class="card-body">
                    @if($sale->details->count()>0)
                    <table id="tabla-purchase-details" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col" class="text-uppercase">Nro</th>
                                <th scope="col" class="text-uppercase">Producto</th>
                                <th scope="col" class="text-uppercase">Cantidad</th>
                                <th scope="col" class="text-uppercase">Precio unitario</th>
                                <th scope="col" class="text-uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sale->details as $key => $detail)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ $detail->price }}</td>
                                <td>{{ $detail->quantity * $detail->price }}</td>
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

@stop
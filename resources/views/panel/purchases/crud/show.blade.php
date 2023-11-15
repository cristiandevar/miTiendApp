@extends('adminlte::page')

@section('title', 'Ver Compra')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos de la Venta nro: "{{ $sale->id }}"</h1>
            <a href="{{ route('sale.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
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
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')

@stop
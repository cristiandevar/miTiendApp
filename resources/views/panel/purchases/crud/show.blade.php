@extends('adminlte::page')

@section('title', 'Ver Compra')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Datos de la Compra nro: "{{ $purchase->id }}"</h1>
            <a href="{{ route('purchase.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver al Listado
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">    
                        <p>Nro: {{ $purchase->id }}</p>
                    </div>
                    <div class="mb-3">    
                        <p>Fecha: {{ $purchase->created_at }}<p>
                    </div>
                    <div class="mb-3">
                        <p>cantidad de Productos: <strong>{{ $purchase->details->count() }}</strong></p>
                    </div>
                    <div class="mb-3">
                        <p>total pagado: <strong>
                            <?php 
                                $acum = 0;
                                foreach ($purchase->details as $detail){
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
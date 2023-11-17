@extends('adminlte::page')

@section('title', 'Crear Detalle de Compra')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Creación de un nuevo detalle de compra</h1>
            <a href="{{ route('purchase.show', $purchase) }}" class="btn btn-sm btn-secondary text-uppercase">
                Volver a la compra
            </a>
        </div>

        <div class="col-12">
            @include('panel.purchasedetails.crud.forms.form')
        </div>

    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
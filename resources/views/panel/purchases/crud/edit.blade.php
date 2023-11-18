@extends('adminlte::page')

@section('title', 'Editar Compra')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Edición de la Compra "{{ $purchase->id }}"</h1>
            @if(isset($back))
                <a href="{{ route('purchase.show', $purchase) }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver
                </a>
            @else
                <a href="{{ route('purchase.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver al Listado
                </a>
            @endif
        </div>
        <div class="col-12">
            @include('panel.purchases.crud.forms.form')
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
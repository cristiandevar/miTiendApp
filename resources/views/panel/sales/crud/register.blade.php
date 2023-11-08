@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Registrar Venta')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Registre su Venta</h1>
@stop
@section('content')

@if(session('alert'))
<div class="col-12">
    <div class="alert alert-success alert-dismissible show" role="alert">
        {{ session('alert') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>                    
    </div>
</div>
@endif

@if(session('error'))
<div class="col-12">
    <div class="alert alert-danger alert-dismissible show" role="error">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>                    
    </div>
</div>
@endif

@stop
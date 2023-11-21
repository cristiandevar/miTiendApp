@extends('adminlte::page')

@section('title','Inicio')

@section('content_header')
    <h1>Informacion Actualizada sobre su tienda</h1>
@stop

@section('content')

<div class="row">
    <div class="col-sm-3">
        <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $purchases_month->count() }}</h3>
              <p>Total de ordenes generadas este mes</p>
            </div>
            <div class="icon">
              <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="{{ route('purchase.index') }}" class="small-box-footer">
              Ir a Compras <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="small-box bg-gradient-success">
            <div class="inner">
              <h3>{{ $sales_month->count() }}</h3>
              <p>Ventas registradas este mes</p>
            </div>
            <div class="icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="{{ route('sale.index') }}" class="small-box-footer">
              Ir a Ventas <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
    </div>
    <div class="col-sm-3">
      <!-- Small box 3 -->
    </div>
    <div class="col-sm-3">
      <!-- Small box 4 -->
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <canvas id="myChart"></canvas>
    </div>
</div>





@stop

@section('css')
    <link 
        rel='stylesheet'
        href='/css/admin_custom.css'
    >
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="{{ asset('js/home/statistic.js') }}"></script>

    <script>
        console.log('Hi!');
    </script>
@stop
@extends('adminlte::page')

@section('title','Inicio')

@section('content_header')
    <h1>Informacion Actualizada sobre su tienda</h1>
@stop

@section('content')
<div class="row">
  <div class="col-12">
    <form class="" action="#" method='GET'>
      <div class="form-group row">
        <select class="form-control col-3" name="type" id="type">
          <option value="1">Ingreso - Egreso</option>
          <option value="2">Compras - Ventas</option>
        </select>

        <select class="form-control col-3" name="range" id="range">
          <option value="1">Anual</option>
          <option value="2">Mensual</option>
          <option value="3">Semanal</option>
        </select>

        
      </div>
    </form>
  </div>
  <div id="div-canvas" class="col-md-12 vh-50">
    <canvas id="myChart"></canvas>
  </div>
  <div class="col-md-6 vh-50">
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
  <div class="col-md-6 vh-50">
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
{{-- <script src="{{ asset('js/home/statistic.js') }}"></script> --}} --}}
{{-- <script type="module" src="/node_modules/vite/dist/client/client.js"></script> --}}
<script  src="{{ asset('js/home/statistic.js') }}"></script>
    <script>
        console.log('Hi!');
    </script>
@stop
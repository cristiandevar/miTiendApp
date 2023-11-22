@extends('adminlte::page')

@section('title','Inicio')

@section('content_header')
    <h1>Informacion Actualizada sobre su tienda</h1>
@stop

@section('content')
<div class="row vh-50">

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
        
        <label for="balance" class="form-control col-2" id="lbl-balance">Balance</label>
        <input type="number" class="form-control col-3" id="balance" name="balance"/>
        
        
      </div>
    </form>
  </div>

  <div id="div-canvas" class="col-md-12">
    <canvas id="myChart"></canvas>
  </div>

</div>



<div class="row vh-50">

  <div class="col-md-6">

    <div class="info-box bg-gradient-success">
      <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
      <div class="info-box-content" id="content-title-1">
        <span class="info-box-text"> </span>
        <span class="info-box-number"></span>
      </div>
    </div>
    <div class="small-box bg-gradient-success">
      <div class="inner" id="data-1">
        <h3></h3>
        <h2></h2>
        <p></p>
      </div>
      <div class="icon">
        <i class="fas fa-crown"></i>
      </div>
      {{-- <a href="{{ route('purchase.index') }}" class="small-box-footer">
        Ir a Compras <i class="fas fa-arrow-circle-right"></i>
      </a> --}}
    </div>
    
    <div class="small-box bg-gradient-success">
      <div class="inner" id="data-3">
        <h3></h3>
        <h2></h2>
        <p></p>
      </div>
      <div class="icon">
        <i class="fas fa-dollar-sign"></i>
      </div>
      {{-- <a href="{{ route('sale.index') }}" class="small-box-footer">
        Ir a Ventas <i class="fas fa-arrow-circle-right"></i>
      </a> --}}
    </div>
  </div>
  <div class="col-md-6 vh-50">
    <div class="info-box bg-gradient-warning">
      <span class="info-box-icon">
        <i class="fas fa-shopping-cart"></i></span>
      <div class="info-box-content" id="content-title-2">
        <span class="info-box-text">Egresos</span>
        <span class="info-box-number"></span>
      </div>
    </div>
    <div class="small-box bg-gradient-warning">
      <div class="inner" id="data-2">
        <h3></h3>
        <h2></h2>
        <p></p>
      </div>
      <div class="icon">
        <i class="fas fa-crown"></i>
      </div>
      {{-- <a href="{{ route('purchase.index') }}" class="small-box-footer">
        Ir a Compras <i class="fas fa-arrow-circle-right"></i>
      </a> --}}
    </div>
    <div class="small-box bg-gradient-warning">
      <div class="inner"  id="data-4">
        <h3></h3>
        <h2></h2>
        <p></p>
      </div>
      <div class="icon">
        <i class="fas fa-dollar-sign"></i>
      </div>
      {{-- <a href="{{ route('sale.index') }}" class="small-box-footer">
        Ir a Ventas <i class="fas fa-arrow-circle-right"></i>
      </a> --}}
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
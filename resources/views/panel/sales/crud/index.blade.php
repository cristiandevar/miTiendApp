{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Ventas')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Lista de Ventas</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            @if ($products->first() && $employees->first())
                <a href="{{ route('sale.create') }}" class="btn btn-success btn-sm text-uppercase">
                    Nueva Venta
                </a>
            @else
                @if (!$products->first())
                    <div>
                        <p>Ingrese primero un Producto desde <a href="{{ route('product.index') }}">aqui</a></p>
                    </div>
                @endif   
                @if (!$employees->first())
                    <div>
                        <p>Ingrese primero un Empleado desde <a href="{{ route('employee.index') }}">aqui</a></p>
                    </div>
                @endif                   
            @endif
        </div>
        
        @if(session('alert'))
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('alert') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                    
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="error">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>                    
                </div>
            </div>
        @endif

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if(count($sales)>0)
                    <table id="tabla-productos" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col" class="text-uppercase">Nro</th>
                                <th scope="col" class="text-uppercase">Fecha Realizada</th>
                                <th scope="col" class="text-uppercase">Cant de productos</th>
                                <th scope="col" class="text-uppercase">Monto Total</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->created_at }}</td>
                                <td>{{ $sale->details->count() }}</td>
                                    
                                @if($sale->details)
                                <td><?php
                                            $total = 0;
                                            foreach ($sale->details as $detail) {
                                                $total += $detail->price * $detail->quantity;
                                            }
                                            echo $total;
                                        ?>
                                    </td>
                                @else
                                <td>0</td>
                                <td>0
                                </td>
                                @endif
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('sale.show', $sale) }}" class="btn btn-sm btn-info text-white text-uppercase me-1 m-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('sale.edit', $sale) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('sale.destroy', $sale) }}" method="POST">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-uppercase m-1">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class='alert alert-danger small'>No tiene Ventas registradas</p>                    

                @endif
            </div>
        </div>
    </div>
</div>
@stop

{{-- Importacion de Archivos CSS --}}
@section('css')
    
@stop


{{-- Importacion de Archivos JS --}}
@section('js')

@stop
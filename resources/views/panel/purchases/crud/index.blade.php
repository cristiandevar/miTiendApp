{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Compras')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Lista de Compras</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            @if ($suppliers->first())
                <a href="{{ route('purchase.create') }}" class="btn btn-success btn-sm text-uppercase">
                    Nueva Compra
                </a>
            @else
                <div>
                    <p>Ingrese primero un Proveedor desde <a href="{{ route('supplier.index') }}">aqui</a></p>
                </div> 
                {{-- @if (!$users->first())
                    <div>
                        <p>Ingrese primero un Empleado desde <a href="{{ route('employee.index') }}">aqui</a></p>
                    </div>
                @endif                    --}}
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
                @if(count($purchases)>0)
                    <table id="tabla-productos" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col" class="text-uppercase">Nro</th>
                                <th scope="col" class="text-uppercase">Proveedor</th>
                                <th scope="col" class="text-uppercase">Fecha Realizada</th>
                                <th scope="col" class="text-uppercase">Cant de productos</th>
                                <th scope="col" class="text-uppercase">Monto Total</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>{{ $purchase->supplier->companyname }}</td>
                                <td>{{ $purchase->created_at }}</td>
                                <td>{{ $purchase->details->count() }}</td>
                                    
                                @if($purchase->details)
                                <td><?php
                                            $total = 0;
                                            foreach ($purchase->details as $detail) {
                                                $total += $detail->price * $detail->quantity;
                                            }
                                            echo $total;
                                        ?>
                                    </td>
                                @else
                                <td>0</td>
                                <td>0</td>
                                @endif
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('purchase.show', $purchase) }}" class="btn btn-sm btn-info text-white text-uppercase me-1 m-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('purchase.edit', $purchase) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('purchase.destroy', $purchase) }}" method="POST">
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
                    <p class='alert alert-danger small'>No tiene Compras registradas</p>                    

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
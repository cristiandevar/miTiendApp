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
                    <table id="table-purchases" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col" class="text-uppercase">Nro</th>
                                <th scope="col" class="text-uppercase">Proveedor</th>
                                <th scope="col" class="text-uppercase">Fecha Realizada</th>
                                <th scope="col" class="text-uppercase">Fecha Recibida</th>
                                <th scope="col" class="text-uppercase">Monto Pagado</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $purchase->id }}</td>
                                <td>{{ $purchase->supplier->companyname }}</td>
                                <td>{{ $purchase->created_at }}</td>
                                <td>{{ $purchase->received_date }}</td>
                                <td>{{ $purchase->total_paid }}</td>
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
                                            <button id="del-purchase" type="submit" class="btn btn-sm btn-danger text-uppercase m-1">
                                                Cancelar
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
@stop

{{-- Importacion de Archivos JS --}}
@section('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
{{-- <script type="text/javascript" src="{{ asset('js/cruds/datatable.js') }}"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('js/cruds/confirm-delete.js') }}"></script>
<script>
    $('#table-purchases').DataTable({
    responsive: true,
    autoWidth: false,
    "order": [[ 0, "desc" ]],
    'language': {
        'lengthMenu':
            'Mostrar'+
                `<select class="custom-select custom-select-sm form-control form-control-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="-1">Todas</option>                        
                </select>`  
            +'filas por pagina',
        'zeroRecords': 'No se encontraron registros',
        'info': 'Mostrando pagina _PAGE_ de _PAGES_',
        'infoEmpty': 'No hay registros disponibles',
        'infoFiltered': '(filtrado de _MAX_ registros)',
        'search':'Buscar',
        'paginate':{
            'next':'Sig.',
            'previous':'Prev.',
        }
    }
})
</script>
@stop
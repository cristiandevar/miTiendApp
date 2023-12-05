{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Empleados')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Lista de Empleados</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            
            @if ($users->first())
                <a href="{{ route('employee.create') }}" class="btn btn-success btn-sm text-uppercase">
                    Nuevo Empleado
                </a>
            @else
                <div>
                    <p>Ingrese primero un usuario desde <a href="#">aqui</a></p>
                </div>
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
                @if(count($employees)>0)
                    <table id="employees-table" class="table table-striped table-hover w-100">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="text-uppercase">Nombre</th>
                                <th scope="col" class="text-uppercase">DNI</th>
                                <th scope="col" class="text-uppercase">Contacto</th>
                                <th scope="col" class="text-uppercase">Opciones</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->id }}</td>
                                <td>{{ $employee->name() }}</td>
                                <td>{{ $employee->dni }}</td>
                                <td>
                                    @if ($employee->email && $employee->phone)
                                        <ul>
                                            <li>{{ Str::limit($employee->email, 80) }}</li>
                                            <li>{{ Str::limit($employee->phone, 80) }}</li>
                                        </ul>
                                    @else
                                        @if ($employee->email)
                                            {{ Str::limit($employee->email, 80) }}
                                        @else
                                            {{ Str::limit($employee->phone, 80) }}
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('employee.show', $employee) }}" class="btn btn-sm btn-info text-white text-uppercase me-1 m-1">
                                            Ver
                                        </a>
                                        <a href="{{ route('employee.edit', $employee) }}" class="btn btn-sm btn-warning text-white text-uppercase me-1 m-1">
                                            Editar
                                        </a>
                                        <form action="{{ route('employee.destroy', $employee) }}" method="POST">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-uppercase me-1 m-1">
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
                    <p class='alert alert-danger small'>No tiene Empleados registrados</p>                    

                @endif
            </div>
        </div>
    </div>
</div>
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
    $('#table-sales').DataTable({
    responsive: true,
    autoWidth: false,
    'language': {
        'lengthMenu':
            'Mostrar'+
                `<select>
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
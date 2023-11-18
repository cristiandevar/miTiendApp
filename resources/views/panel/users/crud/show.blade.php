@extends('adminlte::page')

@section('title', 'Ver Usuario')

@section('content_header')
    
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <form action="{{ route('user.destroy', $user) }}" method="POST" >
            <h1>Datos del Usuario "{{ $user->name }}"</h1>
            <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary col-xs-12 col-1 text-uppercase">
                Volver
            </a>
            <a href="{{ route('user.show-edit', $user->id, 'show.index-'.$user->id) }}" class="btn btn-sm btn-warning col-xs-12 col-1 text-uppercase">
                Editar
            </a>
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger  text-uppercase">
                        Eliminar
                    </button>
                </form>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- <div class="mb-3">    
                        <h2>Nombre: {{ $user->name }}</h2>
                    </div> --}}
                    <div class="mb-3">
                        <p> Email: {{ $user->email }}</p>
                    </div>
                    <div class="mb-3">
                        <p> Rol: 
                            @foreach ($user->role as $rol)
                                {{ $rol->name }}
                            @endforeach
                    </div>
                    <div class="mb-3">
                        <p> Creación {{ $user->created_at }}.</p>
                    </div>
                    <div class="mb-3">
                        <p> Modificación {{ $user->updated_at }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="{{ asset('js/cruds/confirm-delete.js') }}"></script>

@stop
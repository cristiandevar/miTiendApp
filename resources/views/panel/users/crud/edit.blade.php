@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    
@stop

@section('content')
@php
    use Illuminate\Support\Str;
@endphp
<div class="container">
    <div class="row">
        <div class="col-12 mb-3">
            <h1>Edición del Usuario "{{ $user->name }}"</h1>
            @if(isset($back))
                <a href="{{ route('user.show', $user) }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver
                </a>
            @else
                <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary text-uppercase">
                    Volver al Listado
                </a> 
            @endif
            
        </div>
        <div class="col-12">
            @include('panel.users.crud.forms.form')
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
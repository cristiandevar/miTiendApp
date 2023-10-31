{{-- Extiende de la plantilla de Admin LTE, nos permite tener el panel en la vista --}}
@extends('adminlte::page')

{{-- Titulo en las tabulaciones del Navegador --}}
@section('title', 'Productos Filtrados')

{{-- Titulo en el contenido de la Pagina --}}
@section('content_header')
    <h1>Filtro de Productos</h1>
@stop

{{-- Contenido de la Pagina --}}
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 mb-3">
            @if (!$categories->first())
                <div>
                    <p>Ingrese primero una categoria desde <a href="{{ route('category.index') }}">aqui</a></p>
                </div>
            @endif
            @if (!$suppliers->first())
                <div>
                    <p>Ingrese primero un Proveedor desde <a href="{{ route('supplier.index') }}">aqui</a></p>
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
                    <form action="{{ route('product.filter-price') }}" method='GET' id="form-filter">
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            <select id="supplier_id" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
                            <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                        {{ $supplier->companyname }}
                                    </option>
                                @endforeach
                            </select>
                            <select id="category_id" name="category_id" class="form-control col-xs-12 col-2 m-1">
                                <option value=""  {{ !isset($inputs['category_id'])? 'selected':''}}>Categoria...</option>
                                @foreach ($categories as $category)
                                    <option {{ isset($inputs['category_id']) && $inputs['category_id'] == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input class="form-control col-xs-12 col-1 m-1" type="date" id="date_since" name="date_since" placeholder="Fecha desde..." value={{ isset($inputs['date_since'])? $inputs['date_since'] : '' }}>
                            <input class="form-control col-xs-12 col-1 m-1" type="date" id="date_to" name="date_to" placeholder="Fecha hasta..." value={{ isset($inputs['date_to'])? $inputs['date_to'] : '' }}>
                            <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-1 m-1 btn btn-success text-uppercase">
                                Filtrar
                            </button>
                        </div>
                    </form>
                    <form action="{{ route('product.update-price') }}" method='GET' id="form-update">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <input class="form-control col-xs-12 col-2 m-1" type="hidden" id="inputs" name="inputs" value="{{isset($inputs)?json_encode($inputs):''}}">
                            <input class="form-control col-xs-12 col-2 m-1" type="hidden" id="products" name="products" value="{{isset($products)?json_encode($products):''}}">
                           
                            <input class="form-control col-xs-12 col-2 m-1" type="number" id="percentage" name="percentage" placeholder="ingrese porcentaje ..." >
                            <button id="btn-update-1" type="submit" class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                                Actualizar Precio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(count($products)>0)
                        {{-- @include('panel.products.tables.table-main') --}}
                        <table id="tabla-productos" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-uppercase">Nombre</th>
                                    <th scope="col" class="text-uppercase">Precio</th>
                                    <th scope="col" class="text-uppercase">Categoría</th>
                                    <th scope="col" class="text-uppercase">Proveedor</th>
                                    <th scope="col" class="text-uppercase">Imagen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->supplier->companyname }}</td>
                                    <td>
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class='alert alert-danger small'>Ningun producto coincide</p>                    
                    @endif
                </div>
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
<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    );
    document.addEventListener('DOMContentLoaded', function (e) {
        $('#form-update').hide();

        $('#btn-filter-1').on('click', function (e) {
            e.preventDefault();
            var $inputs_form_filter = $('#form-filter :input')
            var values = {};
            $inputs_form_filter.each(function() {
                values[this.name] = $(this).val();
            });

            var data_filter = {
                name : values['name'],
                supplier_id : values['supplier_id'],
                category_id : values['category_id'],
                date_since : values['date_since'],
                date_to : values['date_to'],
            }
            $.ajax({
                    url: 'products-filter-price-async',
                    type: 'GET',
                    data: data_filter,
                    success: function(response) {
                        console.log(response);
                        $('#form-update').show();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                }
            );

        });

        $('#btn-update-1').on('click', function(e) {
            e.preventDefault();
            const products_filtered = '{{ $products }}';
            const categories_filtered = '{{ $categories }}';
            const suppliers_filtered = '{{ $suppliers }}';
            const $inputs_form_update = $('#form-update :input')
            const $inputs_form_filter = $('#form-filter :input')
            var values = {};
            var data_filter;

            $inputs_form_update.each(function() {
                values[this.name] = $(this).val();
            });

            $inputs_form_filter.each(function() {
                values[this.name] = $(this).val();
            });

            data_filter = {
                percentage : values['percentage'],
                products : products_filtered,
                categories : categories_filtered,
                suppliers : suppliers_filtered,
                name : values['name'],
                supplier_id : values['supplier_id'],
                category_id : values['category_id'],
                date_since : values['date_since'],
                date_to : values['date_to'],
            }

            $.ajax({
                    url: 'products-filter-price-update-async',
                    type: 'POST',
                    data: data_filter,
                    success: function(response) {
                        // console.log(response.products);
                        miVariable = decodeURIComponent(response.products.replace(/&quot;/g, '"'));    
                        var miArray = JSON.parse(miVariable);
                        console.log(miArray);   
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                }
            );
        });
    });
</script>
@stop
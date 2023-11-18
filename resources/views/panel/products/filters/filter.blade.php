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
                    <form id="form-filter" action="{{ route('products.export-file') }}" method='GET'>
                        <h6 class="card-header">Descargue su listado</h6>
                        
                        <button id="btn-excel-1" type="submit" name="action" value="excel" class="form-control col-xs-12 col-1 m-1 btn btn-success "title="Exportar datos filtrados en formato .XLSX"><i class="fas fa-file-excel"></i>
                        </button>
                        <button id="btn-pdf-1" type="submit" name="action" value="pdf" class="form-control col-xs-12 col-1 m-1 btn btn-success "title="Exportar datos filtrados en formato .PDF"><i class="fas fa-file-pdf"></i>
                        </button>
                        
                        <h6 class="card-header">Elija los parametros de búsqueda</h6>
                        <div class="form-group row">
                            <input title="Ingrese el código de algun producto" class="form-control col-xs-12 col-2 m-1" type="text" id="code" name="code" placeholder="Código" value={{ isset($inputs) && isset($inputs['code'])? $inputs['code'] : '' }}>
                            <input title="Ingrese el nombre de algun producto" class="form-control col-xs-12 col-2 m-1" type="text" id="name" name="name" placeholder="Nombre" value={{ isset($inputs) && isset($inputs['name'])? $inputs['name'] : '' }}>
                            <select title="Seleccione algun Proveedor" id="supplier_id" name="supplier_id" class="form-control col-xs-12 col-2 m-1">
                            <option value="" {{ !isset($inputs['supplier_id']) || $inputs['supplier_id']==''? 'selected':''}}>Proveedor...</option>
                                @foreach ($suppliers as $supplier)
                                    <option {{ isset($inputs['supplier_id']) && $inputs['supplier_id'] == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                        {{ $supplier->companyname }}
                                    </option>
                                @endforeach
                            </select>
                            <select title="Seleccione alguna Categoria" id="category_id" name="category_id" class="form-control col-xs-12 col-2 m-1">
                                <option value=""  {{ !isset($inputs['category_id'])? 'selected':''}}>Categoria...</option>
                                @foreach ($categories as $category)
                                    <option {{ isset($inputs['category_id']) && $inputs['category_id'] == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input title="Ingrese Precio desde" class="form-control col-xs-12 col-2 m-1" type="number" id="price_since" name="price_since" placeholder="Precio desde..." value={{ isset($inputs['price_since'])? $inputs['price_since'] : '' }}>
                            <input title="Ingrese Precio hasta" class="form-control col-xs-12 col-2 m-1" type="number" id="price_to" name="price_to" placeholder="Precio hasta..." value={{ isset($inputs['price_to'])? $inputs['price_to'] : '' }}>
                            <input title="Ingrese Fecha desde" class="form-control col-xs-12 col-2 m-1" type="date" id="date_since" name="date_since" placeholder="Fecha desde..." value={{ isset($inputs['date_since'])? $inputs['date_since'] : '' }}>
                            <input title="Ingrese Fecha hasta" class="form-control col-xs-12 col-2 m-1" type="date" id="date_to" name="date_to" placeholder="Fecha hasta..." value={{ isset($inputs['date_to'])? $inputs['date_to'] : '' }}>
                        </div>
                        <h6 class="card-header">Elija el criterio de ordenamiento</h6>
                        <select title="Seleccione el orden" id="order_by" name="order_by" class="form-control col-xs-12 col-2 m-1">
                            <option value=""  {{ !isset($inputs['order_by'])? 'selected':''}}>Ordenar...</option>
                            @foreach ($categories as $category)
                                <option >Código</option>
                                <option >Código</option>
                                <option >Código</option>
                                <option >Código</option>
                                <option >Código</option>
                            @endforeach
                        </select>
                        {{-- <button id="btn-filter-1" type="submit" class="form-control col-xs-12 col-2 m-1 btn btn-success text-uppercase">
                            Filtrar
                        </button> --}}
                    </form>
                </div>
            </div>
        </div>
    
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="card-table">
                    @if(count($products)>0)
                        {{-- @include('panel.products.tables.table-main') --}}
                        <div id='alert-table'>
                            <p class='alert alert-danger small'>Ningun producto coincide</p>`
                        </div>
                        <table id="table-products" class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-uppercase">código</th>
                                    <th scope="col" class="text-uppercase">Nombre</th>
                                    <th scope="col" class="text-uppercase">Precio</th>
                                    <th scope="col" class="text-uppercase">Stock</th>
                                    <th scope="col" class="text-uppercase">Categoría</th>
                                    <th scope="col" class="text-uppercase">Proveedor</th>
                                    <th scope="col" class="text-uppercase">Imagen</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-products">
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->code }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock }}</td>
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
                        <p class='alert alert-danger small'>No tiene productos cargados</p>                    
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
{{-- <script type="text/javascript" src="{{ asset('products/js/create-table-filter-products.js') }}"></script> --}}

<script type="text/javascript" src="{{ asset('js/products/filters/create-table-filter-products.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/products/filters/filter-products.js') }}"></script>
@stop
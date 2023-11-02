
<div class="row">
    <div class="col-12 text-center">
        {{ $title }}
    </div>
    <div class="col-6 text-center">
        {{ $subtitle }}
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body" id="card-table">
                @if (count($products) > 0)
                    <table id="table-products" class="table table-striped w-100">
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
                        <tbody id="body-table-products">
                            @foreach ($products as $key => $product)
                            <tr>
                                <td>{{ $key }}</td>
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
                    <p>No Hay productos que coincidadn con los filtros</p>
                @endif
            </div>
        </div>
    </div>
</div>
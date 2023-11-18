
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
                    <table id="table-products" class="table table-border w-100">
                        <thead>
                            <tr>
                                @foreach ($headings as $heading)
                                    <th scope="col">{{ $heading }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody id="body-table-products">
                            @foreach ($products as $key => $product)
                            <tr>
                                @foreach ($columns as $column)
                                    @if ($column == 'category_id')
                                        <td>{{ $product->category->name }}</td>
                                    @elseif ($column == 'supplier_id') 
                                        <td>{{ $product->supplier->companyname }}</td>
                                    @elseif ($column == 'imgage')
                                        <td>
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid" style="width: 150px;">
                                        </td>
                                    @else
                                        <td>{{ $product->$column }}</td>
                                    @endif
                                @endforeach
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
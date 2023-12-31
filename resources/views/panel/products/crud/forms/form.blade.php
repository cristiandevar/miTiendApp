<div class="card mb-5">
    
    @if(isset($back))
        <form action="{{ $product->id ? route('product.show-update', $product) : route('product.store') }}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{{ $product->id ? route('product.update', $product) : route('product.store') }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        
        @if ($product->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($product)->name) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="code" class="col-sm-4 col-form-label"> * Código </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="code" name="code" value="{{ old('code', optional($product)->code) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="price" class="col-sm-4 col-form-label"> * Precio </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', optional($product)->price) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="stock" class="col-sm-4 col-form-label"> * Stock </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', optional($product)->stock) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="minstock" class="col-sm-4 col-form-label"> Stock Minimo (opcional) </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="minstock" name="minstock" value="{{ old('minstock', optional($product)->minstock) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="active" class="col-sm-4 col-form-label"> * Activo </label>
                <div class="">
                    <input type="checkbox" class="form-control" id="active" name="active" {{ $product->active ? 'checked' : ''}} >
                </div>
            </div>

            <div class="mb-3 row">
                <label for="category" class="col-sm-4 col-form-label"> * Categoria </label>
                <div class="col-sm-8">
                    <select id="category_id" name="category_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option {{ $product->category_id && $product->category_id == $category->id ? 'selected': ''}} value="{{ $category->id }}"> 
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="supplier" class="col-sm-4 col-form-label"> * Proveedor </label>
                <div class="col-sm-8">
                    <select id="supplier_id" name="supplier_id" class="form-control" required>
                        @foreach ($suppliers as $supplier)
                            <option {{ $product->supplier_id && $product->supplier_id == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                {{ $supplier->companyname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
        </div>

        <div class="mb-3 row">
            <label for="description" class="col-sm-4 col-form-label"> Descripción (opcional) </label>
            <div class="col-sm-8">
                <textarea class="form-control" id="description" name="description" rows="10" >{{ old('description', optional($product)->description) }}</textarea>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="image" class="col-sm-4 col-form-label"> Imagen (opcional) </label>
            <div class="col-sm-8">
                <input class="form-control" type="file" id="image" name="image" accept="image/*">
            </div>
        </div>

        <div class="mb-3 row">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/1024'}}" alt="{{ $product->name }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;">
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $product->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>
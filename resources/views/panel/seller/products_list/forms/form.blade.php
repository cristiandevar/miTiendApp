<div class="card mb-5">
    <form action="{{ $product->id ? route('product.update', $product) : route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($product->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <img src="{{ $product->image ?? 'https://via.placeholder.com/1024'}}" alt="{{ $product->name }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;">
            </div>

            <div class="mb-3 row">
                <label for="image" class="col-sm-4 col-form-label"> * Imagen </label>
                <div class="col-sm-8">
                    <input class="form-control" type="file" id="image" name="image" accept="image/*" required>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($product)->name) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="description" class="col-sm-4 col-form-label"> * Descripción </label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="description" name="description" rows="10" >{{ old('description', optional($product)->description) }}</textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="price" class="col-sm-4 col-form-label"> * Precio </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', optional($product)->price) }}" required>
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
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $product->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const image = document.getElementById('image');
        
            image.addEventListener('change', (e) => {

                const input = e.target;
                const imagePreview = document.querySelector('#image_preview');
                
                if(!input.files.length) return

                file = input.files[0];
                objectURL = URL.createObjectURL(file);
                imagePreview.src = objectURL;
            });
        });
    </script>
@endpush
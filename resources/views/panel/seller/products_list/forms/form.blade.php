<div class="card mb-5">
    <form action="{{ $producto->id ? route('producto.update', $producto) : route('producto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($producto->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <img src="{{ $producto->imagen ?? 'https://via.placeholder.com/1024'}}" alt="{{ $producto->nombre }}" id="image_preview" class="img-fluid" style="object-fit: cover; object-position: center; height: 420px; width: 100%;">
            </div>

            <div class="mb-3 row">
                <label for="imagen" class="col-sm-4 col-form-label"> * Imagen </label>
                <div class="col-sm-8">
                    <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="nombre" class="col-sm-4 col-form-label"> * Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', optional($producto)->nombre) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="descripcion" class="col-sm-4 col-form-label"> * Descripción </label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="10" required>{{ old('descripcion', optional($producto)->descripcion) }}</textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="precio" class="col-sm-4 col-form-label"> * Precio </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="precio" name="precio" value="{{ old('precio', optional($producto)->precio) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="categoria" class="col-sm-4 col-form-label"> * Categoria </label>
                <div class="col-sm-8">
                    <select id="categoria_id" name="categoria_id" class="form-control" required>
                        @foreach ($categorias as $categoria)
                            <option {{ $producto->categoria_id && $producto->categoria_id == $categoria->id ? 'selected': ''}} value="{{ $categoria->id }}"> 
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $producto->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const image = document.getElementById('imagen');
        
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
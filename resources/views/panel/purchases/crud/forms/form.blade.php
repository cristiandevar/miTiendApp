<div class="card mb-5">
    <form action="{{ $purchase->id ? route('purchase.update', $purchase) : route('purchase.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($purchase->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Fecha </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="date" name="date" value={{$date}} disabled>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="category" class="col-sm-4 col-form-label"> * Proveedor </label>
                <div class="col-sm-8">
                    <select id="supplier_id" name="supplier_id" class="form-control" required>
                        @foreach ($suppliers as $supplier)
                            <option {{ $supplier->id && $supplier->id == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="active" class="col-sm-4 col-form-label"> * Activa </label>
                <div class="">
                    <input type="checkbox" class="form-control" id="active" name="active" {{ $purchase->active ? 'checked' : ''}} >
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success text-uppercase">
                    {{ $purchase->id ? 'Actualizar' : 'Crear' }}
                </button>
            </div>

        </div>
    </form>

</div>

@push('js')
    {{-- <script>
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
    </script> --}}
@endpush
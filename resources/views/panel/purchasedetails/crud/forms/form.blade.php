<div class="card mb-5">
    <form action="{{ $purchasedetail->id ? route('purchasedetail.update', $purchasedetail) : route('purchase.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($purchasedetail->id)
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3 row">
                <label for="purchase_id" class="col-sm-4 col-form-label"> * Orden </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="purchase_id" name="purchase_id" value={{$purchase_id}} disabled>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="product_id" class="col-sm-4 col-form-label"> * Producto </label>
                <div class="col-sm-8">
                    <select id="purchase_id" name="purchase_id" class="form-control" required>
                        @foreach ($products as $product)
                            <option {{ $product->id && $product->id == $product->id ? 'selected': ''}} value="{{ $product->id }}"> 
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="quantity_ordered" class="col-sm-4 col-form-label"> Cantidad Ordenada</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="quantity_ordered" name="quantity_ordered" value={{$purchasedetail->quantity_ordered??}}>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="quantity_received" class="col-sm-4 col-form-label"> Cantidad Recibida</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="quantity_received" name="quantity_received" value={{$purchasedetail->quantity_received??}}>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="cost_price" class="col-sm-4 col-form-label"> Precio de costo</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="cost_price" name="cost_price" value={{$purchasedetail->cost_price??}}>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="active" class="col-sm-4 col-form-label"> * Activa </label>
                <div class="">
                    <input type="checkbox" class="form-control" id="active" name="active" {{ $purchasedetail->active ? 'checked' : ''}} >
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success text-uppercase">
                    {{ $purchasedetail->id ? 'Actualizar' : 'Crear' }}
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
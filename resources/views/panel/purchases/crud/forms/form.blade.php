<div class="card mb-5">
    @if(isset($back))
        <form action="{{ $purchase->id ? route('purchase.show-update', $purchase) : route('purchase.store') }}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{{ $purchase->id ? route('purchase.update', $purchase) : route('purchase.store') }}" method="POST" enctype="multipart/form-data">
    @endif
    
    {{-- <form action="{{ $purchase->id ? route('purchase.update', $purchase) : route('purchase.store') }}" method="POST" enctype="multipart/form-data"> --}}
        @csrf
        
        @if ($purchase->id)
            @method('PUT')
        @endif

        <div class="card-body">
            <div class="mb-3 row">
                <label for="supplier" class="col-sm-4 col-form-label"> * Proveedor </label>
                <div class="col-sm-8">
                    <select id="supplier_id" name="supplier_id" class="form-control" required>
                        @foreach ($suppliers as $supplier)
                            <option {{ $supplier->id && $supplier->id == $supplier->id ? 'selected': ''}} value="{{ $supplier->id }}"> 
                                {{ $supplier->companyname }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Fecha Emisión</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="date" name="date" value={{$date}} disabled>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="received_date" class="col-sm-4 col-form-label"> * Fecha Recepcion </label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="received_date" name="received_date" value={{$purchase->received_date?date('Y-m-d', strtotime($purchase->received_date))  : date('Y-m-d', strtotime($date))}}>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="total_paid" class="col-sm-4 col-form-label"> * Total Pagado </label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="total_paid" name="total_paid" value={{$purchase->total_paid??0}}>
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
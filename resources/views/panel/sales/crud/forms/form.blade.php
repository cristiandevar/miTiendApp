<div class="card mb-5">
    <form action="{{ $product->id ? route('product.update', $product) : route('product.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($product->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Fecha </label>
                <div class="col-sm-8">
                    <input type="date" class="form-control" id="date" name="date" value="{{ old('name', optional($product)->name) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="category" class="col-sm-4 col-form-label"> * Empleado </label>
                <div class="col-sm-8">
                    <select id="employee_id" name="employee_id" class="form-control" required>
                        @foreach ($employees as $employee)
                            <option {{ $employee->employee_id && $employee->employee_id == $employee->id ? 'selected': ''}} value="{{ $employee->id }}"> 
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success text-uppercase">
                    {{ $product->id ? 'Actualizar' : 'Crear' }}
                </button>
            </div>

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
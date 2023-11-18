<div class="card mb-5">
    <form action="{{ $sale->id ? route('sale.update', $sale) : route('sale.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($sale->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Fecha </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="date" name="date" value={{$today}} disabled>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="category" class="col-sm-4 col-form-label"> * Usuario </label>
                <div class="col-sm-8">
                    <select id="user_id" name="user_id" class="form-control" required>
                        @foreach ($users as $user)
                            <option {{ $user->id && $user->id == $user->id ? 'selected': ''}} value="{{ $user->id }}"> 
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="active" class="col-sm-4 col-form-label"> * Activa </label>
                <div class="">
                    <input type="checkbox" class="form-control" id="active" name="active" {{ $sale->active ? 'checked' : ''}} >
                </div>
            </div>
            
            <div class="card-footer">
                <button type="submit" class="btn btn-success text-uppercase">
                    {{ $sale->id ? 'Actualizar' : 'Crear' }}
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
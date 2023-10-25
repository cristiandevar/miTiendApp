<div class="card mb-5">
    <form action="{{ $category->id ? route('category.update', $category) : route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($category->id)
            @method('PUT')
        @endif

        <div class="card-body">
            
            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Nombre </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($category)->name) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="active" class="col-sm-4 col-form-label"> * Activo </label>
                <div class="">
                    <input type="checkbox" class="form-control" id="active" name="active" {{ $category->active ? 'checked' : ''}}>
                </div>
            </div>
        
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $category->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>
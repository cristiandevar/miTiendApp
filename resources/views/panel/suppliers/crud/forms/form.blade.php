<div class="card mb-5">
    <form action="{{ $supplier->id ? route('supplier.update', $supplier) : route('supplier.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($supplier->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="companyname" class="col-sm-4 col-form-label"> * Nombre de la Empresa </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="companyname" name="companyname" value="{{ old('companyname', optional($supplier)->companyname) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-sm-4 col-form-label"> Direccion (opcional)</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', optional($supplier)->address) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-sm-4 col-form-label"> Email (opcional)</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email', optional($supplier)->email) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-sm-4 col-form-label"> Telefono (opcional)</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone', optional($supplier)->phone) }}">
                </div>
            </div>
        
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $supplier->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>

@push('js')
@endpush
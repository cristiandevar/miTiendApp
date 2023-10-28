<div class="card mb-5">
    <form action="{{ $employee->id ? route('employee.update', $employee) : route('employee.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if ($employee->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="lastname" class="col-sm-4 col-form-label"> * Apellido/s </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname', optional($employee->lastname)) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="firstname" class="col-sm-4 col-form-label"> * Nombre/s </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="firstname" name="fisrtname" value="{{ old('firstname', optional($employee->firstname)) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="dni" class="col-sm-4 col-form-label"> * DNI </label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="dni" name="dni" rows="10" required>{{ old('dni', optional($employee)->dni) }}</textarea>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-sm-4 col-form-label"> Email (opcional)</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="email" name="email" value="{{ old('email', optional($employee)->email) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-sm-4 col-form-label"> Telefono (opcional)</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone', optional($employee)->phone) }}">
                </div>
            </div>

            <div class="mb-3 row">
                <label for="user" class="col-sm-4 col-form-label"> * Usuario </label>
                <div class="col-sm-8">
                    <select id="user_id" name="user_id" class="form-control" required>
                        @foreach ($Users as $user)
                            <option {{ $employee->user_id && $employee->user_id == $user->id ? 'selected': ''}} value="{{ $user->id }}"> 
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $employee->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>

@push('js')
@endpush
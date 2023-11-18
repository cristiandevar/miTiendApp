<div class="card mb-5">
    @if(isset($back))
        <form action="{{ $user->id ? route('user.show-update', $user) : route('user.store') }}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{{ $user->id ? route('user.update', $user) : route('user.store') }}" method="POST" enctype="multipart/form-data">
    @endif
    
    @csrf
        
        @if ($user->id)
            @method('PUT')
        @endif

        <div class="card-body">

            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label"> * Nombre de usuario </label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', optional($user)->name) }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-sm-4 col-form-label"> * Email </label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', optional($user)->email) }}" required>
                </div>
            </div>
            @if(!$user->id)            
                <div class="mb-3 row">
                    <label for="password" class="col-sm-4 col-form-label"> * Password </label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password" name="password" value="" required>
                    </div>
                </div>
            
                <div class="mb-3 row">
                    <label for="password_again" class="col-sm-4 col-form-label"> * Repita Password </label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="password_again" name="password_again" value="" required>
                    </div>
                </div>
            @endif
            
            

            <div class="mb-3 row">
                <label for="role" class="col-sm-4 col-form-label"> * Rol </label>
                <div class="col-sm-8">
                    <select id="role_id" name="role_id" class="form-control" required>
                        @foreach ($roles as $rol)
                            <option {{ $user->id && $rol->id == $user->role->first->id->id ? 'selected': ''}} value="{{ $rol->id }}"> 
                                {{ $rol->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-success text-uppercase">
                {{ $user->id ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>

</div>

@push('js')
@endpush
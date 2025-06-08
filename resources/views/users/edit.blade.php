@extends('plantilla')

@section('title', 'Editar usuario')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Editar usuario</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Usuarios</a></li>
            <li class="breadcrumb-item active">Editar usuario</li>
        </ol>

        <div class="from-orange-200">
            <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group mb-2">
                    <label for="name">Usuario</label>
                    <input type="text" style="color: gray" class="form-control" name="name" id="name"
                        placeholder="introduzca un nombre de usuario" value="{{ $user->name }}" readonly>
                    @error('name')
                        <small class="text-danger"> {{ '*' . $message }} </small>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label for="email">Correo electrónico</label>
                    <input type="email" class="form-control" name="email" id="email"
                        placeholder="nombre@ejemplo.com" value="{{ $user->email }}">
                    @error('email')
                        <small class="text-danger"> {{ '*' . $message }} </small>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label for="inputPassword">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="inputPassword"
                        placeholder="Ingrese nueva contraseña">
                    @error('password')
                        <small class="text-danger"> {{ '*' . $message }} </small>
                    @enderror
                </div>

                <div class="form-group mb-2">
                    <label for="personal_id">Personal del salón</label>
                    <select class="form-select" id="personal_id" name="personal_id" data-placeholder="Seleccione personal">
                        <option value="">-- No asignar personal --</option>
                        @foreach ($personals as $persona)
                            <option value="{{ $persona->id }}" {{ $user->personal_id == $persona->id ? 'selected' : '' }}>
                                {{ $persona->name }} - {{ $persona->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="cliente_id">Cliente (si aplica)</label>
                    <select name="cliente_id" class="form-select">
                        <option value="">-- No asignar cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $user->cliente_id == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->name }} - {{ $cliente->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-4">
                    <label for="role" class="col-lg-2 col-form-label">Seleccionar rol:</label>
                    <div class="col-lg-4">
                        <select name="role" id="role" class="form-select">
                            @foreach ($roles as $item)
                                <option value="{{ $item->name }}" {{ in_array($item->name, $user->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                                    {{ ucfirst($item->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-text">Escoja un rol para el usuario.</div>
                    </div>
                    <div class="col-lg-2">
                        @error('role')
                            <small class="text-danger">{{ '*' . $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                    <button type="reset" class="btn btn-secondary btn-sm">Restaurar datos</button>
                    <a href="{{ route('users.index') }}">
                        <button type="button" class="btn btn-success btn-sm">
                            <i class="fa-solid fa-arrow-left"></i> Atrás
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $('#personal_id').select2({
            theme: "bootstrap-5",
            width: '100%',
            placeholder: 'Seleccione personal',
        });
    </script>
@endpush

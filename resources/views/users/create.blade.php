@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Usuario</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">👁️</button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="role" class="form-select" required>
                <option value="">-- Seleccionar rol --</option>
                @foreach($roles as $rol)
                <option value="{{ $rol->name }}" {{ old('role') == $rol->name ? 'selected' : '' }}>
                    {{ ucfirst($rol->name) }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Empleado (si aplica)</label>
            <select name="empleado_id" class="form-select">
                <option value="">-- No asignar empleado --</option>
                @foreach($empleados as $empleado)
                <option value="{{ $empleado->id }}" {{ old('empleado_id') == $empleado->id ? 'selected' : '' }}>
                    {{ $empleado->name }} - {{ $empleado->email }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Cliente (si aplica)</label>
            <select name="cliente_id" class="form-select">
                <option value="">-- No asignar cliente --</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                    {{ $cliente->name }} - {{ $cliente->email }}
                </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endsection
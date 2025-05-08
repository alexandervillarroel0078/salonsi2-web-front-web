<!-- resources/views/cargo_empleados/create.blade.php -->
@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Registrar Nuevo Cargo</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cargos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label><strong>Nombre del Cargo</strong></label>
            <input type="text" name="cargo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label><strong>Estado</strong></label>
            <select name="estado" class="form-control" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-success px-4">Guardar</button>
            <a href="{{ route('cargos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

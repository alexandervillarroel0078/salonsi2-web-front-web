@extends('layouts.ap')

@section('content')
<div class="container">
    <h2 class="mb-4">Registrar Asistencia</h2>

    <form method="POST" action="{{ route('asistencias.store') }}">
        @csrf

        <div class="mb-3">
            <label for="personal_id" class="form-label">Selecciona Personal</label>
            <select name="personal_id" id="personal_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                @foreach ($personals as $personal)
                    <option value="{{ $personal->id }}">{{ $personal->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="">-- Seleccionar --</option>
                <option value="presente_local">Presente en el salón</option>
                <option value="presente_domicilio">Presente a domicilio</option>
                <option value="ausente">Ausente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <input type="text" name="observaciones" id="observaciones" class="form-control" placeholder="Opcional">
        </div>

        <button type="submit" class="btn btn-success">Guardar Asistencia</button>
    </form>
</div>
@endsection

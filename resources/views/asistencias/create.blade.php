@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Registrar Asistencia</h4>

    <form method="POST" action="{{ route('asistencias.store') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label><strong>Personal</strong></label>
                <select name="personal_id" class="form-control" required>
                    <option value="">-- Seleccionar --</option>
                    @foreach($personals as $personal)
                        <option value="{{ $personal->id }}">{{ $personal->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label><strong>Fecha</strong></label>
                <input type="text" name="fecha" class="form-control" value="{{ now()->format('Y-m-d') }}" readonly>
            </div>
            <input type="hidden" name="hora" value="{{ now()->format('H:i') }}">
<div class="col-md-3">
    <label><strong>Hora de Entrada</strong></label>
    <input type="text" class="form-control" value="{{ now()->format('H:i') }}" readonly disabled>
</div>

        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <label><strong>Estado</strong></label>
                <select name="estado" class="form-control" required>
                    <option value="presente_local">Presente (Salón)</option>
                    <option value="presente_domicilio">Presente (Domicilio)</option>
                    <option value="ausente">Ausente</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label><strong>Observación</strong></label>
            <textarea name="observaciones" class="form-control" rows="2"></textarea>
        </div>

        <div class="text-end">
            <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Asistencia</button>
        </div>
    </form>
</div>
@endsection

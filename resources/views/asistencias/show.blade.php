@extends('layouts.ap')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Detalle de Asistencia de: <strong>Juan Pérez</strong></h4>

    <!-- Filtros -->
    <form method="GET" action="#" class="row g-3 align-items-end mb-4">
    <div class="col-md-3">
        <label><strong>Mes</strong></label>
        <select name="mes" class="form-control">
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ $m == 5 ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($m)->locale('es')->translatedFormat('F') }}
                </option>
            @endfor
        </select>
    </div>
    <div class="col-md-3">
        <label><strong>Año</strong></label>
        <select name="anio" class="form-control">
            @for($a = now()->year; $a >= now()->year - 5; $a--)
                <option value="{{ $a }}" {{ $a == 2025 ? 'selected' : '' }}>{{ $a }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
    </div>
</form>


    <!-- Tabla de asistencias -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Tipo de Atención</th>
                        <th>Servicio Realizado</th>
                        <th>Observación</th>
                        <th>Justificación</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Ejemplo estático -->
                    <tr>
                        <td>2025-05-01</td>
                        <td><span class="badge bg-success">Presente</span></td>
                        <td>Salón</td>
                        <td>Corte + Peinado</td>
                        <td>Atención normal</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>2025-05-02</td>
                        <td><span class="badge bg-danger">Ausente</span></td>
                        <td>-</td>
                        <td>-</td>
                        <td>No se presentó</td>
                        <td>Permiso médico</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
            ← Volver a la lista
        </a>
    </div>
</div>
@endsection
